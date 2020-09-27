@extends('layouts.app')

@section('content')
<div class="container" dir="rtl" style="text-align: right!important;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">لوحة التحكم</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">

                        </div>
                    @endif

                    تم تسجيل دخولك
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4>
                       <a href="/form" class="card-link">
                           النماذج
                       </a>
                    </h4>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
