<section class="content-header">
	<h1>
	{{ get_title('') }}
	{% if config_link %}
		<small><a href="{{ config_link }}"><i class="fa fa-gear"></i>&nbsp;Настройки</a></small>
	{% endif %}
	</h1>
	<ol class="breadcrumb">
		{{ partial('breadcrumb') }}
	</ol>
</section>
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
