@extends('layout.index2')
	@section('title')
	<li class="active">
     <i class="fa fa-file"></i> Distribution Areas
    </li>
	@endsection
	@section('content')
		<div class="row" >
                    <div class="col-lg-12 page-header">
                        <ol class="breadcrumb">
                        	<li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li>
                            Distribution Areas
                            </li>
                            
                        </ol>
                        <h1>Delivery Locations</h1>
                    </div>
                </div>

		<div ng-app="mainApp" id="module2" class="container col-sm-12">
			
			<div  ng-controller="citiesController as distribution" class="table-responsive">
			<div class="col-sm-4 ">
			<div class="list-group" >
				<a href="#" class="list-group-item" style="background:#466178;color:#fff;">
	            	STATES
	            </a>
	        </div>
			<div  style="height:400px; overflow:scroll;">
			<table class="table  table-hover" >

				<tbody>
				@foreach( $states as $state)
					<tr style="background:#404040;">
						<td ng-class="{ActiveNav: distribution.tab==={{$state->id}}}" >
							<a href=""  ng-click="distribution.setTab({{$state->id}})" style="color:#fff;">{{$state->name}}</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			</div>
		</div>

		<div class="col-sm-4 ">
			<div class="list-group" >
				<a href="#" class="list-group-item" style="background:#466178;color:#fff;">
	            	CITIES
	            	
	            	<button ng-show="distribution.tab" class="btn btn-xs btn-default pull-right" ng-click="distribution.Editor1()"> 
	            		<i class="fa fa-plus"></i>
	            	</button>
	            </a>
	        </div>
			<div style="height:400px; overflow:scroll;" >
				<table class="table">
					<tr ng-show="distribution.showEditor1">
						<td>
							<input type="text" placeholder="Name or Names Separated with commas" 
								ng-model="distribution.Cities.cityname"
								class="form-control" ng-required="true">
						</td>

					</tr>
					<tr ng-show="distribution.showEditor1">
						<td >
							<div class="btn-group pull-right">
								<button class="btn btn-xs btn-primary" ng-click="distribution.saveCity()" ng-show="distribution.Cities.cityname">
									Save
								</button>
								<button class="btn btn-xs btn-danger" ng-click="distribution.cancelEditor1()" >
									Cancel
								</button>
							</div>
						</td>
					<tr>
						
					<tr ng-repeat="city in distribution.CityReturn" style="background:#404040;">
						<td ng-class="{ActiveNav: distribution.tab2===@{{city.id}}}">
							<a href="#" ng-click="distribution.setTab2(city.id)" style="color:#fff;">@{{city.name}}</a>
							<button class="btn btn-xs btn-danger pull-right" style="margin-left:30px;" ng-click="distribution.confirmDelete('city',city.id)"> 
								<i class="fa fa-trash-o"></i>
							</button>
						</td>
					</tr>
				</table>
			</div>
	    </div>

	    <div class="col-sm-4 ">
			<div class="list-group" >
				<a href="#" class="list-group-item" style="background:#466178;color:#fff;">
	            	AREAS & MARKETER
	            	<button ng-show="distribution.tab2" class="btn btn-xs btn-default pull-right" ng-click="distribution.Editor2()"> 
	            		<i class="fa fa-plus"></i>
	            	</button>
	            </a>
	        </div>
	        <div style="height:400px; overflow:scroll;" >
				<table class="table">
					<tr ng-show="distribution.showEditor2">
						<td>
							<input type="text" placeholder="Name or Names Separated with commas" class="form-control"
							ng-model="distribution.Areas.areaname"
							 ng-required="true">
						</td>
					</tr>
					<tr ng-show="distribution.showEditor2">
						<td >
							<div class="btn-group pull-right">
								<button class="btn btn-xs btn-primary" ng-click="distribution.saveArea()" ng-show="distribution.Areas.areaname">
									Save
								</button>
								<button class="btn btn-xs btn-danger" ng-click="distribution.cancelEditor2()" >
									Cancel
								</button>
							</div>
						</td>
					<tr>
					<tr ng-repeat="area in distribution.AreaReturn" style="background:#404040;">
						<td>
							<a href="#" style="color:#fff;">@{{area.name}}</a>
							<button ng-show="area.marketer" class="btn btn-default btn-xs" style="margin-left:50px;">@{{area.marketer}}</button>
							<button class="btn btn-xs btn-default pull-right" ng-click="distribution.confirmDelete('area',area.id)"  > 
								<i class="fa fa-trash-o"></i>
							</button>
							<button class="btn btn-xs btn-default pull-right"  ng-click="distribution.toggle(area.name,area.id)" > 
								<i class="fa fa-user"></i>
							</button>
							
						</td>
					</tr>
				</table>
			</div>
		</div>
						<!-- Modal (Pop up when detail button clicked) -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	            <div class="modal-dialog">
	                <div class="modal-content">
	                    <div class="modal-header ActiveNav" >
	                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	                        <h4 class="modal-title" id="myModalLabel">Attach Marketer To @{{distribution.formTitle}}</h4>
	                    </div>
	                    <div class="modal-body">
	                        <form name="AttachmentFrm" class="form-horizontal" novalidate="">
                                 <div class="form-group">
                                    <div class="col-sm-12" ng-class="{ 'has-error' : AttachmentFrm.name.$invalid && AttachmentFrm.name.$touched }">
                                    	
                                       <select class="form-control"  ng-required="true" name="name" ng-model="distribution.marketerName" >
                                       	@foreach($marketers as $marketer)
                                       		<option value="{{$marketer->id}}">{{$marketer->name}}</option>
                                        @endforeach()
                                       </select>
                                       <p ng-show="AttachmentFrm.name.$invalid && AttachmentFrm.name.$touched" class="help-block">This field required.</p>
                                    </div>
                                </div>
								


	                        </form>
	                        </div>
	                       <div class="modal-footer ActiveNav">
	                       <button type="button" class="btn btn-primary" id="btn-save" ng-click="distribution.attachMarketer()" ng-disabled="AttachmentFrm.$invalid">Save changes</button>
	                       </div>
	                    </div>
	            </div>
	        </div>
		



	    </div>
	</div>
		

	@endsection