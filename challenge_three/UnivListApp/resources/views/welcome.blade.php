@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="">
        <table class="table table-striped" id="table">
            <thead>
            <tr>
                <th class="col-lg-3" scope="col">Name</th>
                <th class="col-lg-2" scope="col">State</th>
                <th class="col-lg-1" scope="col">Code</th>
                <th class="col-lg-2" scope="col">Country</th>
                <th class="col-lg-2" scope="col">View Domain(s)</th>
                <th class="col-lg-2" scope="col">View Website(s)</th>

            </tr>
            </thead>
            <tbody>
            @foreach($universities as $univ)
                <tr>
                    <td scope="row">{{$univ->name}}</td>
                    <td>{{$univ->name}}</td>
                    <td>{{$univ->alpha_two_code}}</td>
                    <td>{{$univ->country}}</td>
                    <td><a href="#" class="link-info pe-auto" onclick="viewDomain({{$univ->id}})">View Domain</a></td>
                    <td><a href="#" class="link-info pe-auto" onclick="viewWebPages({{$univ->id}})">View Web Pages</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="empModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header col-lg-12">
                    <h4 class="modal-title ">Added Information</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('afterscript')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                pagingType: 'full_numbers',
                processing:true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
            });
        });

        function viewDomain(univId){
            $('.modal-body').html("");
            $.ajax({
                type:'GET',
                url:"/get-domain/" + univId,
                data:'_token = {{csrf_token()}}',
                success:function(data) {
                    jQuery.each(data, function(index, value){
                        $('.modal-body').append("<p>" + value.domain + "</p>");
                    });

                    // Display Modal
                    jQuery.noConflict();
                    $('#empModal').modal('show');
                }
            });
        }

        function viewWebPages(univId){
            $('.modal-body').html("");
            $.ajax({
                type:'GET',
                url:"/get-web-pages/" + univId,
                data:'_token = {{csrf_token()}}',
                success:function(data) {
                    jQuery.each(data, function(index, value){
                        $('.modal-body').append("<p><a href='" + value.url + "' target='_blank'>" + value.url + "</a></p>");
                    });

                    // Display Modal
                    jQuery.noConflict();
                    $('#empModal').modal('show');
                }
            });
        }
    </script>
@stop
