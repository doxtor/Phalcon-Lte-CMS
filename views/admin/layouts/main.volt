<div class="container-fluid h-100">
	<div class="row h-100">
		{{ partial('menu') }}
		<main class="col bg-faded py-3">
			{{ flash.output() }}
			{{ content() }}

		<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header"><a href="{{ edit_link }}" class="btn btn-success" role="button">Новый</a>
					<div class="box-body">
					<div class="row">
						<div class="col-sm-12">
							{{ partial('table') }}
						</div>
					</div>
					<div class="row">
						{{ partial('pagination') }}
					</div></div>
					</div>
				</div>
				</div>
			</div>
		</section>
</main>
</div>
</div>
{{ assets.outputJs('footer_admin') }}
{% do assets.addJs('js/list.js') %}
{{ assets.outputJs() }}
