@extends('layouts.app')

@section('content')
<main class="c-main">
    <div class="c-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Customer Name')}}</th>
                                    <th>{{__('Address')}}</th>
                                    <th>{{__('Total purchased')}}</th>
                                    <th>{{__('Payment method')}}</th>                                    
                                    <th>{{__('Created At')}}</th>
                                    <th>{{__('Status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr class="text-center">
                                        <td>{{$order->id}}</td>
                                        <td>{{$order->phoneNumber}}</td>
                                        <td>{{$order->address}}</td>
                                        <td>{{$order->total}} đ</td>
                                        <td><svg class="icon">
                                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-wallet')}}"></use>
                                        </svg></td>
                                        <td>{{$order->created_at}}</td>
                                        <td>
                                            <form action="{{route('admin.orders.elevateStatus',$order->id)}}" method="POST">
                                                @csrf
                                                @if($order->order_status == 0 )
                                                <button class="btn btn-warning" type="submit"
                                                onclick="return confirm('Are you sure you want to update this?');">
                                                    Waiting
                                                </button>
                                                @elseif($order->order_status == 1)
                                                <button class="btn btn-success" type="submit"
                                                onclick="return confirm('Are you sure you want to update this?');">
                                                    On Prepared
                                                </button>
                                                @else
                                                <button class="btn btn-info active">Done</button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center"
                            {{ $orders->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
