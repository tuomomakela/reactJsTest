<!DOCTYPE html>
<html>
  <head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/react-with-addons.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/JSXTransformer.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	<script src="smartSortable.js" type="text/jsx"></script>
	<script src="sortableList.js" type="text/jsx"></script>
	<!--link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" /-->
	<link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div id="content"></div>
    <script type="text/jsx">
		var App = React.createClass({
			render: function() {
				return (
					<div>
						<h1>React test</h1>
						<p>List with create, read, update, delete and sort actions</p>
						<SortableList />
						<p><b>Todo:</b>
							<ol>
								<li>Ajax calls</li>
								<li>Testing Flux architecture</li>
							</ol>
						</p>
					</div>
				);
			}
		});
		React.render(
			<App />,
			document.getElementById('content')
		);
    </script>
  </body>
</html>