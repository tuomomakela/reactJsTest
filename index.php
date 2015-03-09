<!DOCTYPE html>
<html>
  <head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/react-with-addons.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/JSXTransformer.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	<script src="smartSortable.js"></script>
	<!--link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" /-->
	<link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div id="content"></div>
    <script type="text/jsx">
		 
		
		var List = React.createClass({
			getInitialState: function() {
				var data = [
					{name: "A"},
					{name: "B"},
					{name: "C"}
				];
				// set isEdited false for every item
				for (var i = 0; i < data.length; ++i) {
					data[i].isEdited = false;
				}
				return {
					data: data
				};
			},
			/* start editing name of item */
			handleEdit: function(index) {
				var data = this.state.data;
				data[index] = React.addons.update(
					this.state.data[index], {
						isEdited: {$set: true}
					}
				);
				this.setState(data);
				console.log(this.state.data[index]);
			},
			/* save change of name */
			handleSave: function(index) {
				// ajax to handle save
				var data = this.state.data;
				data[index] = React.addons.update(
					this.state.data[index], {
						name: {$set: this.refs["name_"+index].getDOMNode().value.trim()},
						isEdited: {$set: false}
					}
				);
				this.setState(data);
				console.log(this.state.data[index]);
			},
			/* cancel changing a name */
			handleCancel: function(index) {
				var data = this.state.data;
				data[index] = React.addons.update(
					this.state.data[index], {
						isEdited: {$set: false}
					}
				);
				this.setState(data);
				console.log(this.state.data[index]);
			},
			handleDelete: function(index) {
				// ajax to handle delete
				var data = this.state.data;
				data.splice(index, 1);
				this.setState(data);
				console.log(this.state.data);
			},
			handleSubmit: function(event) {
				event.preventDefault();
				var data = this.state.data;
				data[data.length] = {
					name: this.refs.newName.getDOMNode().value.trim(),
					isEdited: false
				}
				// ajax to handle save
				this.setState(data);
				this.refs.newName.getDOMNode().value = '';
			},
			handleSort: function(newOrder) {
				var newItems = newOrder.map(function(index) {
					return this.state.data[index];
				}.bind(this));
				this.setState({data: newItems});
			},
			render: function() {
				var items = this.state.data.map(function(item, i) {
					return (
						<div key={i} className="listElement" ref={"li_"+i}>
							{
								item.isEdited
									? <div className="textElem">
										<span>
											<input type="text" defaultValue={item.name} ref={"name_"+i} />
											<input type="button" value="Save" onClick={this.handleSave.bind(this,i)} />
											<input type="button" value="Cancel" onClick={this.handleCancel.bind(this,i)} />
										</span>
									  </div>
									: <div className="textElem" onClick={this.handleEdit.bind(this,i)}>
										<span>
											{item.name}
										</span>
									  </div>
							}
							<div className="deleteElem" onClick={this.handleDelete.bind(this,i)}>
								[x]
							</div>
						</div>
					)
				}.bind(this));
				return(
					<div className="listContainer">
						<SmartSortable onSort={this.handleSort} className="list">
							{ items }
						</SmartSortable>
						<ul className="list">
							<li className="listElement listNewItem">
								<form className="createNewForm" onSubmit={this.handleSubmit}>
									<div className="textElem">
										<input type="text" placeholder="New item" ref="newName" />
									</div>
									<div className="saveBtnElem">
										<input type="submit" value="Save" />
									</div>
								</form>
							</li>
						</ul>
					</div>
				);
			}
		});
		var App = React.createClass({
			render: function() {
				return (
					<div>
						<h1>React test</h1>
						<p>List with create, read, update, delete and sort actions</p>
						<List />
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