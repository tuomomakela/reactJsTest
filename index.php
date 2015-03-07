<!DOCTYPE html>
<html>
  <head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/react-with-addons.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/JSXTransformer.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css" />
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
				return(
					<li className="listElement" ref="li">
						<div className="textElem">
							{textData}
						</div>
						<div className="deleteElem" onClick={this.handleDelete}>
							[x]
						</div>
					</li>
				);
			}
		});
		var CreateElement = React.createClass({
			handleSubmit: function(event) {
				event.preventDefault();
				var name = this.refs.name.getDOMNode().value.trim();
				if (!name) return;
				// ajax to handle save
				this.props.onNewItemSubmit({name: name});
				this.refs.name.getDOMNode().value = '';
			},
			render: function() {
				return (
					<li className="listElement">
						<form className="createNewForm" onSubmit={this.handleSubmit}>
							<div className="textElem">
								<input type="text" placeholder="New item" ref="name" />
							</div>
							<div className="saveBtnElem">
								<input type="submit" value="Save" />
							</div>
						</form>
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
			handleNewItemSubmit: function(name) {
				this.state.data = React.addons.update(this.state.data, {$push: [{name: name}]});
				console.log(this.state.data[this.state.data.length-1].name);
				// problem is that this.state.data is not correct
				// this could be avoided by getting entire data here from database
				// in database data should be correct all the time
				this.forceUpdate();
			},
			render: function() {
				var itemData = this.state.data.map(function(item) {
					return (
						<ListElement {...item} />
					);
				});
				return(
					<ul className="list">
						{itemData}
						<CreateElement onNewItemSubmit={this.handleNewItemSubmit} />
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