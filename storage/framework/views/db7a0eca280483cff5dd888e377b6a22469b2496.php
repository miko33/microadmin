<?php $__env->startSection('widget-body'); ?>

<div class="widget-list row">

	<div class=" row col-md-12 no-gutters mb-2">
		<form class="form-inline " method="get" action="<?php echo e(url('/')); ?>">
			<select name="game" class="custom-select mb-2 mr-sm-2 mb-sm-0" id="type">
				<?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<optgroup label="<?php echo e(ucfirst($division->name)); ?>">
					<?php $__currentLoopData = explode(',', $division->game); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($division->name.'_'.$game); ?>"><?php echo e($game); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</optgroup>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>

			<div class="input-group mb-2 mr-sm-2 mb-sm-0">
				<div class="input-daterange input-group datepicker">
					<span class="input-group-addon bg-info text-inverse">from</span> 
					<input id="start" type="text" class="form-control" name="start" value="<?php echo e($startdate); ?>"/>
					<span class="input-group-addon bg-info text-inverse ml-1">to</span> 
					<input id="end" type="text" class="form-control" name="end" value="<?php echo e($endDate); ?>"/>
				</div>
			</div>
			<button type="submit" name="submit" class="btn btn-primary">Filter</button>
		</form>
	</div>

	<div class="widget-holder widget-full-height widget-flex col-md-12 col-lg-6">
		<div class="widget-bg">
			<div class="widget-heading">
				<h4 class="widget-title"><span id="chartvidcategory" class="color-color-scheme fw-600"></span> <small class="h5 ml-1 my-0 fw-500">Uploaded Vidoes</small></h4>
				<div class="widget-graph-info"><i class="feather feather-chevron-up arrow-icon color-success"></i><span class="color-success ml-2">+34%</span>  <span class="text-muted ml-1">more than last week</span>
				</div>
				<!-- /.widget-graph-info -->
			</div>
			<!-- /.widget-heading -->
			<div class="widget-body">
				<div class="mr-t-10 flex-1">
					<div class="h-100" style="max-height: 270px">
						<canvas id="chartJsNewUsers" style="height:100%"></canvas>
					</div>
				</div>
			</div>
			<!-- /.widget-body -->
		</div>
		<!-- /.widget-bg -->
	</div>
	<!-- /.widget-holder -->
	<div class="col-md-12">
		<div class="row">
			<div class="widget-holder widget-sm widget-border-radius col-md-6 col-lg-3 ">
				<div class="widget-bg">
					<div class="widget-heading"><span class="widget-title my-0 fs-12 fw-600">Categories</span>  <i class="widget-heading-icon feather feather-anchor"></i>
					</div>
					<!-- /.widget-heading -->
					<div class="widget-body">
						<div class="counter-w-info">
							<div class="counter-title">
								<div class="d-flex justify-content-center align-items-end">
									<div data-toggle="circle-progress" data-start-angle="30" data-thickness="6" data-size="40" data-value="0.58" data-line-cap="round" data-empty-fill="#E2E2E2" data-fill='{"gradient": ["#40E4C2", "#0087FF"], "gradientAngle": -90}'></div><span class="counter ml-3"><?php echo e($category); ?></span>
								</div>
								<!-- /.d-flex -->
							</div>
							<!-- /.counter-title -->
							<div class="counter-info"><span class="badge bg-success-contrast"><i class="feather feather-arrow-up"></i> 5% increase</span>
							</div>
							<!-- /.counter-info -->
						</div>
						<!-- /.counter-w-info -->
					</div>
					<!-- /.widget-body -->
				</div>
				<!-- /.widget-bg -->
			</div>
			<!-- /.widget-holder -->
			<div class="widget-holder widget-sm widget-border-radius col-md-6 col-lg-3">
				<div class="widget-bg">
					<div class="widget-heading"><span class="widget-title my-0 fs-12 fw-600">Videos</span><i class="widget-heading-icon feather feather-zap"></i>
					</div>
					<!-- /.widget-heading -->
					<div class="widget-body">
						<div class="counter-w-info">
							<div class="counter-title">
								<div class="d-flex justify-content-center align-items-center"><span data-toggle="sparklines" sparkheight="25" sparktype="bar" sparkchartrangemin="0" sparkbarspacing="3" sparkbarcolor="#947AE8" sparkbarcolor="red"><!-- 2,4,5,3,2,3,5 --> </span><span class="align-bottom ml-2"><span class="counter"><?php echo e($video); ?></span></span>
								</div>
								<!-- /.d-flex -->
							</div>
							<!-- /.counter-title -->
							<div class="counter-info"><span class="badge bg-success-contrast"><i class="feather feather-arrow-up"></i> 5% increase </span>in advertising</div>
							<!-- /.counter-info -->
						</div>
						<!-- /.counter-w-info -->
					</div>
					<!-- /.widget-body -->
				</div>
				<!-- /.widget-bg -->
			</div>
			<!-- /.widget-holder -->
		</div>
	</div>
</div>
<!-- /.widget-list -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- CHART  -->
<script type="text/javascript">
	var ctx = document.getElementById("chartJsNewUsers");
	ctx = ctx.getContext('2d');

	var gradient = ctx.createLinearGradient(0,20,20,270);
	gradient.addColorStop(0,'rgba(130,83,235,0.6)');
	gradient.addColorStop(1,'rgba(130,83,235,0)');

	var datevalue = [];
	var count = [];
	var totalvid = 0;

	<?php if($dates!=null): ?> 
	<?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	datevalue.push('<?php echo e($value->date); ?>');
	count.push('<?php echo e($value->count); ?>');
	totalvid += parseInt("<?php echo e($value->count); ?>");
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>

	$("#chartvidcategory").html(totalvid);

			// console.log(totalvid);

			var data = {

				labels: datevalue,
				datasets: [
				{
					label: 'Videos Upload',
					lineTension: 0,
					data: count,
					backgroundColor: gradient,
					hoverBackgroundColor: gradient,
					borderColor: '#8253eb',
					borderWidth: 2,
					pointRadius: 4,
					pointHoverRadius: 4,
					pointBackgroundColor: 'rgba(255,255,255,1)'
				}
				]
			};

			var chart = new Chart(ctx, {
				type: 'line',
				data: data,
				responsive: true,
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false,
					},
					scales: {
						xAxes: [{
							gridLines: {
								display: false,
								drawBorder: false,
								tickMarkLength: 20,
							},
							ticks: {
								fontColor: "#bbb",
								padding: 10,
								fontFamily: 'Roboto',
							},
						}],
						yAxes: [{
							gridLines: {
								color: '#eef1f2',
								drawBorder: false,
								zeroLineColor: '#eef1f2',
							},
							ticks: {
								fontColor: "#bbb",
								stepSize: 50,
								padding: 20,
								fontFamily: 'Roboto',
							}
						}]
					},
				},
			});

			$(document).on('SIDEBAR_CHANGED_WIDTH', function() {
				chart.resize();
			});

			$(window).on('resize', function() {
				chart.resize();
			});
		</script>

		<!-- CURRENT SELECTED DATE -->
		<!-- <script type="text/javascript">
			// var currentDate = new Date();
			// $("#start").datepicker().datepicker("setDate",new Date());

			var date = new Date();
			date.setDate(date.getDate() - 0);

			$("#start").datepicker({
				dateFormat: "yy-mm-dd",
				defaultDate: date,
				onSelect: function () {
					selectedDate = $.datepicker.formatDate("yy-mm-dd", $(this).datepicker('getDate'));
				}
			});

			$("#start").datepicker("setDate", date);

		</script> -->

		<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>