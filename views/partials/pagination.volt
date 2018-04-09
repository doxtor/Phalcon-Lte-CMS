
<form action="" method="get">
<div class="col-sm-6">
    <ul class="pagination">
        <select name="limit" class="input-sm" onchange="this.form.submit()">
        <option value="10"{% if limit == 10 %} selected="selected"{% endif %}>10</option>
        <option value="25"{% if limit == 25 %} selected="selected"{% endif %}>25</option>
        <option value="50"{% if limit == 50 %} selected="selected"{% endif %}>50</option>
        <option value="100"{% if limit == 100 %} selected="selected"{% endif %}>100</option>
        </select>
    </ul>
</div>
<div class="col-sm-6">
    <ul class="pagination">
        <li class="paginate_button previous{% if pagination.current == 1 %} disabled{% endif %}">
            <a href="{{ link }}?page={{ pagination.before }}">Назад</a>
        </li>
        {% if pagination.total_pages > 10 %}
            {% if pagination.current > 5 %}
                {% for i in pagination.current-4..pagination.current+5 %}
                    {% if i <= pagination.total_pages %}
                        <li class="paginate_button{% if pagination.current == i %} active{% endif %}">
                            <a href="{{ link }}?page={{ i }}">{{ i }}</a>
                        </li>
                    {% endif %}
                {% endfor %}
            {% else %}
                {% for i in 1..10 %}
                    <li class="paginate_button{% if pagination.current == i %} active{% endif %}">
                        <a href="{{ link }}?page={{ i }}">{{ i }}</a>
                    </li>
                {% endfor %}
            {% endif %}
        {% else %}
            {% for i in 1..pagination.total_pages %}
                <li class="paginate_button{% if pagination.current == i %} active{% endif %}">
                    <a href="{{ link }}?page={{ i }}">{{ i }}</a>
                </li>
            {% endfor %}
        {% endif %}
        <li class="paginate_button next{% if pagination.current == pagination.total_pages %} disabled{% endif %}">
            <a href="{{ link }}?page={{ pagination.next }}">Следующий</a>
        </li>
    </ul>
</div>
</form>
