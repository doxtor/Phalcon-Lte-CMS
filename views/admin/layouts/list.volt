{{ partial('menu') }}
<div class="content-wrapper">
	<div class="container-fluid">
		{{ partial('breadcrumb') }}
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
				{{ get_title('') }}
				<div class="float-right">
					<a href=""><i class="fas fa-plus"></i></a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
						{{ flash.output() }}
						{{ content() }}
						{{ partial('table') }}
				</div>
			</div>
		</div>
	</div>
	{{ partial('footer') }}
</div>
{{ assets.outputJs('footer_admin') }}
{{ assets.outputJs() }}
