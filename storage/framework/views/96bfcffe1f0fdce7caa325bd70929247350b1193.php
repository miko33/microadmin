<?php $__env->startSection('widget-body'); ?>

<content-index  style="display: none;" >
<link rel="stylesheet" href="<?php echo e(url('assets/css/documentation.css')); ?>" type="text/css">
<div id="content" class="mw-body" role="main">
	<div id="bodyContent" class="mw-body-content">
		<div id="mw-content-text" lang="id" dir="ltr" class="mw-content-ltr">
			<div class="">
				<a href="<?php echo e(route('adddoc')); ?>" class="create btn btn-sm btn-primary ml-1 float-right" style=" margin:10px;"> Add Documentation</a>
			<div id="div1" class="mw-parser-output row container-fluid bg-white">
				<div class="col-md-9">
					<h1 id="firstHeading" class="firstHeading" lang="id"><u>Template 1</u></h1>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
						<div class="slide-window">
			      <span class="nav" id="leftNav"></span>
			      <div class="slide-holder">
			        <div class="slide" id="slide1">
								 <div class="info-bar">Gambar</div>
			          <img class="pic" src="https://backgrounddownload.com/wp-content/uploads/2018/09/background-pemandangan-senja-5.jpg">
			        </div>
			        <div class="slide" id="slide2">
								 <div class="info-bar">Gambar2</div>
			          <img class="pic" src="https://c.pxhere.com/photos/3b/a1/sunset_nova_scotia_canada_dusk_sun_sky_landscape_orange-941856.jpg!d">
			        </div>
			          <div class="slide" id="slide2">
			        </div>
			      </div>
			      <span class="nav" id="rightNav"></span>
			    </div>
					</div>
					<div class="col-md-3">
						<table class="infobox pull-right" style="text-align: left; width: 200px; font-size: 100%">
							<tbody >
								<tr>
									<th colspan="2" style="text-align: center; background-color: rgb(235,235,210)">Template 1
									</th></tr>
									<tr>
										<td colspan="2" style="text-align: center"><a class="image">
											<img  src="//upload.wikimedia.org/wikipedia/commons/thumb/8/81/Egretta_thula1.jpg/200px-Egretta_thula1.jpg" width="200" height="306" >
										</a>
									</td></tr>
								</tbody>
							</table>
						</div>
					</div>
					<br>
							</div>
						</div>
					</div>
				</content-index>

				<content-form>
					<form id="general-form">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tittle</label>
								<input type="text" id="inputTitle" name="title" class="form-control">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label >Description</label>
								<textarea id="inputDescription" name="description" class="form-control"></textarea>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="inputTitle">Image profile</label>
								<input type="file" id="inputProfile" name="profile" class="form-control">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label >Image Slider</label>
								<input type="file" id="inputSlider" name="Slider" multiple="multiple" class="form-control">
							</div>
						</div>
						<div class="form-actions btn-list">
							<button class="btn btn-success" type="button" id="microsite_submit">Submit</button>
							<button class="cancel btn btn-outline-default" type="button">Cancel</button>
						</div>

					</form>
				</content-form>
					<?php $__env->stopSection(); ?>
					<?php $__env->startPush('scripts'); ?>
					<script src="<?php echo e(url('assets/js/documentation.js?v=0.1')); ?>"></script>
					<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
					<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>