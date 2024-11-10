
<div id="notifications">
    @php
        $notificationsData = Helper::getOrderNotifications();
    @endphp
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Order
        <i class="fas fa-bell fa-fw"></i>
        @if($notificationsData['count']>0)
        <span class="badge badge-danger badge-counter">
            <span data-count="" class="count">{{ $notificationsData['count'] }}</span>
        </span>
        @endif
        
    </a>
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">Notifications Center</h6>
        <div class="notification-items">
            @if ($notificationsData['ord-N-Read']->isEmpty())
                <div class="dropdown-item text-center small text-gray-500">No new notifications</div>
            @else
                @php
                    // Limit to 5 notifications for display
                    $notificationsToShow = $notificationsData['ord-N-Read']->take(5);
                @endphp
                @foreach ($notificationsToShow as $notification)
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('order.show', $notification['order_id']) }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-bolt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ $notification->created_at->format('F d, Y h:i A') }}</div>
                            <span class="">{{ $notification->message }}</span>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
        {{-- @if ($notificationsData['count'] > 5) --}}
            <a class="dropdown-item text-center small text-gray-500" href="{{route('admin.notification.all')}}">Show All Notifications</a>
        {{-- @endif --}}
    </div>
</div>




<script>
    // $(document).ready(function() {
    //     function fetchNotification() {
    //         $.ajax({
    //             url: '{{ route('admin.notification.order_notify') }}',
    //             type: 'GET',
    //             success: function(data) {
    //                 console.log(data); 
    //                 let notificationList = $('.notification-items');
    //                 notificationList.empty();

    //                 $('.badge-counter .count').text(data.count < 5 ? data.count : '5+');

    //                 if (data.notifications.length === 0) {
    //                     notificationList.append('<div class="dropdown-item text-center small text-gray-500">No new notifications</div>');
    //                 } else {
    //                     data.forEach(function(notification) {
    //                         const notificationItem = `
    //                             <a class="dropdown-item d-flex align-items-center" href="">
    //                                 <div class="mr-3">
    //                                     <div class="icon-circle bg-primary">
    //                                         <i class="fas ${notification.data.fas} text-white"></i>
    //                                     </div>
    //                                 </div>
    //                                 <div>
    //                                     <div class="small text-gray-500">${new Date(notification.created_at).toLocaleString()}</div>
    //                                     <span class="${notification.read_at ? 'small text-gray-500' : 'font-weight-bold'}">${notification.data.title}</span>
    //                                 </div>
    //                             </a>`;
    //                         notificationList.append(notificationItem);
    //                     });
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.log('Error fetching notifications: ', error);
    //             }
    //         });
    //     }

    //     fetchNotification();
    //     setInterval(fetchNotification, 3000);
    // });
</script>





{{-- <script>
     let interval;
    $(document).ready(function(){
        function fetchNotification()
        {
            $.ajax({
                url:'route("admin.notification.order_notify")',
                type: 'GET',
                success : function(data){
                    let notificationList = $('#notifications');
                    notificationList.empty();

                    data.foreach(function(notification){
                       notificationList.append() 
                    });
                    clearInterval(interval);
                    interval = null;
                },
                error: function(xhr,status,error){
                    console.log('Error fetching notification : ',error)
                }
            });
        }
    }); 
    fetchNotification();
    // $('#reload-bttn').on('click', function(){
    //     if(interval){
    //         clearInterval(interval);
    //     }
    //     interval = setInterval(fetchNotification,3000)
    // });
</script> --}}
