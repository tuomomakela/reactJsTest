<!DOCTYPE html>
<html>
  <head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/react.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/JSXTransformer.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  </head>
  <body>
    <div id="content"></div>
    <script type="text/jsx">
		var ListElement = React.createClass({
			getInitialState: function() {
				return {
					isEdited: false,
					name: this.props.name
				};
			},
			/*handleChange: function(event) {
				this.setState({name: event.target.value});
			},*/
			handleEdit: function(event) {
				this.setState({isEdited: true});
				console.log("start editing");
			},
			handleSave: function(event) {
				// ajax to handle save
				this.setState({name: this.refs.name.getDOMNode().value.trim()});
				this.setState({isEdited: false});
			},
			handleCancel: function(event) {
				this.setState({isEdited: false});
			},
			handleDelete: function(event) {
				// ajax to handle delete
				React.unmountComponentAtNode(this.refs.li.getDOMNode());
				$(this.refs.li.getDOMNode()).remove();
			},
			render: function() {
				var textData = this.state.isEdited
					? <span>
						<input type="text" defaultValue={this.state.name} ref="name" />
						<input type="button" value="Save" onClick={this.handleSave} />
						<input type="button" value="Cancel" onClick={this.handleCancel} />
					  </span>
					: <span onClick={this.handleEdit}> {this.state.name} </span>
				var liStyle = {
					width: '400px',
					padding: '2px',
					margin: '2px',
					'background-color': '#eeeeee',
					height: '20px'
				};
				var textStyle = {
					width: '300px',
					display: 'inline',
					float: 'left'
				};
				var deleteStyle = {
					width: '100px',
					cursor: 'pointer',
					'text-align': 'center',
					display: 'inline',
					float: 'left'
				};
				return(
					<li style={liStyle} className="listElement" ref="li">
						<div style={textStyle}>
							{textData}
						</div>
						<div style={deleteStyle} onClick={this.handleDelete}>
							[x]
						</div>
					</li>
				);
			}
		});
		var List = React.createClass({
			getInitialState: function() {
				return {
					data: [
						{name: "A"},
						{name: "B"},
						{name: "C"}
					]
				}
			},
			render: function() {
				var itemData = this.state.data.map(function(item) {
					return (
						<ListElement {...item} />
					);
				});
				var ulStyle = {
					'list-style-type': 'none'
				};
				return(
					<ul style={ulStyle}>
						{itemData}
					</ul>
				);
			}
		});
		React.render(
			<List />,
			document.getElementById('content')
		);
    </script>
  </body>
</html>