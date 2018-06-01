{{ partial('menu') }}
<div class="content-wrapper">
	<div class="container-fluid">
		{{ partial('breadcrumb') }}
		{{ flash.output() }}
		{{ content() }}
	</div>
	{{ partial('footer') }}
</div>
{{ assets.outputJs('footer_admin') }}
{{ assets.outputJs() }}
