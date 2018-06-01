<section class="content">
<form action="{{ save_link }}" method="post" enctype="multipart/form-data">
{% for namegroup, items in variables %}
	<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{ namegroup }}</h3>
	</div>
	<div class="box-body">
		{% for name, item in items %}
			<div class="row form-group">
				<label for="input{{ name }}" class="col-sm-2 control-label">{{ item['name'] }}</label>
				<div class="col-sm-10">
				{{ form.render(name) }}
				</div>
			</div>
		{% endfor  %}
	</div>
	</div>
{% endfor  %}
<div class="box-footer">
	<button type="submit" class="btn btn-success">Сохранить</button>
</div>
</form>
</section>
