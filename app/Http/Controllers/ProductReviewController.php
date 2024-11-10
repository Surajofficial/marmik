<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Notifications\StatusNotification;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\File;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = ProductReview::getAllReview();
        return view('backend.review.index')->with('reviews', $reviews);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('customSearch', ''); 
        // return $searchTerm;
        $query = ProductReview::with('user_info', 'product')
                    ->when($searchTerm, function ($query, $searchTerm) {
                        return $query->where('review', 'LIKE', "%{$searchTerm}%")
                                ->orWhereHas('user_info', function($q) use ($searchTerm) {
                                    $q->where('name', 'LIKE', "%{$searchTerm}%");
                                })
                                ->orWhereHas('product', function($q) use ($searchTerm) {
                                    $q->where('title', 'LIKE', "%{$searchTerm}%");
                                });
                    });

        // Get the total number of records without filtering
        $totalRecords = $query->count();
        
        // Paginate the results
        $reviews = $query->take($request->length)->offset($request->start)->get(); 

        // Prepare response data
        return response()->json([
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Adjust this if you want filtered records count
            'data' => $reviews, // Send the paginated items
        ]);
    }










    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'rate' => 'required|numeric|min:1'
        ]);
        $product_info = Product::getProductBySlug($request->slug);

    
    // Initialize data array for ProductReview creation
    $data = $request->all();
    $data['product_id'] = $product_info->id;
    $data['user_id'] = $request->user()->id;
    $data['status'] = 'active';

    // Create the ProductReview record
    $productReview = ProductReview::create($data);

    // Check if images were uploaded
    if ($request->hasFile('productPhotos')) {
        $images = $request->file('productPhotos');
        $imagePaths = [];

        foreach ($images as $image) {
            // Generate a unique file name
            $fileName = time() . '_' . $image->getClientOriginalName();
            
            // Define the path to store the image in the 'public/product_photos' directory
            $publicPath = public_path('product_photos');
            
            // Create the directory if it doesn't exist
            if (!File::exists($publicPath)) {
                File::makeDirectory($publicPath, 0755, true);
            }
            
            // Move the image to the public directory
            $image->move($publicPath, $fileName);
            
            // Collect the path to store in the database
            $imagePaths[] = 'product_photos/' . $fileName;
        }

        // Store the image paths in the database (assuming 'image' is a field in the 'product_reviews' table)
        $productReview->image = implode(',', $imagePaths);
        $productReview->save();
    }

        $user = Admin::get();
        $details = [
            'title' => 'New Product Rating!',
            'actionURL' => route('product-detail', $product_info->slug),
            'fas' => 'fa-star'
        ];
        Notification::send($user, new StatusNotification($details));
        if ($productReview) {
            session()->flash('success', 'Thank you for your feedback');
        } else {
            session()->flash('error', 'Something went wrong! Please try again!!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = ProductReview::find($id);
        // return $review;
        return view('backend.review.edit')->with('review', $review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $review = ProductReview::find($id);
    if ($review) {
        // Prepare data to update the review
        $data = $request->except('productPhotos', 'delete_images');

        // Update other review fields
        $review->fill($data)->save();

        // Handle image deletions
        if ($request->has('delete_images')) {
            $deleteImages = $request->delete_images;

            foreach ($deleteImages as $image) {
                // Delete the image file from the storage
                $filePath = public_path($image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Update the image field
            $existingImages = explode(',', $review->image);
            $newImages = array_diff($existingImages, $deleteImages); // Keep the images that are not deleted
            $review->image = implode(',', $newImages);
        }

        // Handle new image uploads
        if ($request->hasFile('productPhotos')) {
            $images = $request->file('productPhotos');
            $imagePaths = [];

            foreach ($images as $image) {
                // Generate a unique file name
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define the path to store the image in the 'public/product_photos' directory
                $publicPath = public_path('product_photos');

                // Create the directory if it doesn't exist
                if (!File::exists($publicPath)) {
                    File::makeDirectory($publicPath, 0755, true);
                }

                // Move the image to the public directory
                $image->move($publicPath, $fileName);

                // Collect the path to store in the database
                $imagePaths[] = 'product_photos/' . $fileName;
            }

            // Merge new images with existing images
            if (!empty($review->image)) {
                $existingImages = explode(',', $review->image);
                $allImages = array_merge($existingImages, $imagePaths);
                $review->image = implode(',', $allImages);
            } else {
                $review->image = implode(',', $imagePaths);
            }
        }

        // Save the updated review
        $review->save();

        // Flash success message
        request()->session()->flash('success', 'Review Successfully updated');
    } else {
        request()->session()->flash('error', 'Review not found!!');
    }

    return redirect()->route('review.index');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = ProductReview::find($id);
        $status = $review->delete();
        if ($status) {
            request()->session()->flash('success', 'Successfully deleted review');
        } else {
            request()->session()->flash('error', 'Something went wrong! Try again');
        }
        return redirect()->route('review.index');
    }

    public function addreview(){
        $users = User::all();
        $product = Product::all();
        // Pass the data to the 'addreview' view
        return view('backend.review.addreview', ['users' => $users, 'products' => $product]);
    }

    public function addreviewpost(Request $request){
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rate' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
            'productPhotos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        // Create a new ProductReview entry
        $productReview = new ProductReview;
        $productReview->user_id = $request->user_id;
        $productReview->product_id = $request->product_id;
        $productReview->rate = $request->rate;
        $productReview->review = $request->review;
        $productReview->status = 'active'; // Default to active or customize as needed
        $imagePaths = [];
    
        // Check if files are uploaded and handle the images
        if ($request->hasFile('productPhotos')) {
            $images = $request->file('productPhotos');
    
            foreach ($images as $image) {
                // Generate a unique file name
                $fileName = time() . '_' . $image->getClientOriginalName();
                
                // Define the path to store the image in the 'public/product_photos' directory
                $publicPath = public_path('product_photos');
                
                // Create the directory if it doesn't exist
                if (!File::exists($publicPath)) {
                    File::makeDirectory($publicPath, 0755, true);
                }
                
                // Move the image to the public directory
                $image->move($publicPath, $fileName);
                
                // Collect the path to store in the database
                $imagePaths[] = 'product_photos/' . $fileName;
            }
    
            // Store the image paths in the 'image' field of ProductReview table
            $productReview->image = implode(',', $imagePaths);
        }
    
        // Save the product review to the database
        $productReview->save();
    
        // Redirect or return a success response
        return redirect()->back()->with('success', 'Review added successfully!');
    }



}
