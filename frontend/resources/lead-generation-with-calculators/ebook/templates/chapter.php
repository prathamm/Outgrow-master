{% extends "layouts/main.php" %}

{% block title %}
	{{ this_chapter['name'] }}
{% endblock %}

{% block content %}
{{ parent() }}

	<div class="chapter-holder">
		{{ include(this_chapter['template']) }}
	</div>

{% endblock %}
