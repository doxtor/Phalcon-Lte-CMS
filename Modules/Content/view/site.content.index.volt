{% for item in paginator.items %}
	<div class="post-preview">
		<a href="post.html">
			<h2 class="post-title">{{ item.name }}</h2>
			<h3 class="post-subtitle">{{ item.descr }}</h3>
		</a>
		<p class="post-meta">Posted by <a href="#">{{ item.user_name }}</a> on {{ item.created_dt }}</p>
	</div>
	<hr>
{% endfor %}
{{ partial('pagination') }}
