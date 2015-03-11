
var SortableList = React.createClass({
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
		this.setState({data:data});
		this.handleSearch();
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
	handleOrder: function(order, field) {
		var data = this.state.data;
		var bigger  = (order == "asc" ? 1 : -1);
		var smaller = (order == "asc" ? -1 : 1);
		data.sort(function(a,b) {return (a[field] > b[field]) ? bigger : ((b[field] > a[field]) ? smaller : 0);});
		this.setState({data: data});
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
				<ul className="list">
					<li className="listElement">
						<div className="textElem">
							<div>Order:&nbsp;</div>
							<div onClick={this.handleOrder.bind(this,"asc","name")}>asc</div>
							<div>&nbsp;&nbsp;|&nbsp;&nbsp;</div>
							<div onClick={this.handleOrder.bind(this,"desc","name")}>desc</div>
						</div>
					</li>
				</ul>
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
