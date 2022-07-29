@extends('layouts.app')

@section('head')
	<link rel="stylesheet" href="{{ asset('css/jkanban.min.css') }}">
	<style>
		/* カードの設定 */
		.kanban-item .text-red {
		color: crimson;
		}
		.kanban-item .text-bold {
		font-weight: bold;
		}
		.kanban-item.orange {
		color: white;
		background-color: darkorange;
		}
		.kanban-item .item-body img {
		width: 100%;
		}
		.kanban-item .item-body {
		max-height: 240px;
		overflow: hidden;
		}
		/* カラムのタイトルの色 */
		.kanban-board header {
		color: white;
		background-color: gray;
		}
		.kanban-board header.red {
		background-color: crimson;
		}
		.kanban-board header.blue {
		background-color: royalblue;
		}
		.kanban-board header.green {
		background-color: green;
		}
	</style>
@endsection

@section('content')
	<div class="card">
		<div class="card-header"><h4>Task</h4></div>
	</div>
	<div class="mb-3">
		<button type="button" data-toggle="modal" data-target="#createBoard" class="btn btn-primary">Tambah Board</button>
		<button type="button" data-toggle="modal" data-target="#createTask" class="btn btn-primary" id="tambah">Tambah Task</button>
	</div>
	<div id="kanban-canvas">
	<!-- ここにカンバンが表示される -->
</div>
@endsection


@push('modals')
	<div class="modal fade" id="createBoard" tabindex="-1" aria-labelledby="createBoardLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form action="{{ route('project.task.store', $projectId) }}" method="post">
				@csrf
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="createBoardLabel">Tambah Board</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="name">Nama Board</label>
							<input type="text" name="name" id="name" placeholder="Nama Board" class="form-control">
						</div>
						<div class="form-group">
							<label for="class">Warna</label>
							<input type="text" name="class" id="class" placeholder="Warna Board" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary">Tambah</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endpush

@push('scripts')
<script src="{{ asset('js/jkanban.min.js') }}"></script>
<script>
		const splitEnd = function(Data, Separator) {
			const Array = Data.split(Separator);
			
			return Array[Array.length - 1];
		}

		$.ajax({
			url: window.location.href,
			method: 'GET',
			success: function(res){
				let dataContent = [];

				res.map((val, i) => {
					const obj = {
						"id": "column-id-"+val.id,
						"title": val.name,
						"class": val.class,
						"item" : []
						
					}
					val.tasks.map((val, i) => {
						obj.item.push({
							"id": "item-id-"+val.id,
							"title": val.name
						})
						
					})
					dataContent.push(obj);
				})
				const kanban = new jKanban({
					
					element: '#kanban-canvas', // カンバンを表示する場所のID
					boards: dataContent, // カンバンに表示されるカラムやカードのデータ
					gutter: '16px', // カンバンの余白
					widthBoard: '275px', // カラムの幅 (responsivePercentageの「true」設定により無視される)
					responsivePercentage: true, // trueを選択時はカラム幅は％で指定され、gutterとwidthBoardの設定は不要
					dragItems: true, // trueを選択時はカードをドラッグ可能
					dragBoards: true, // カラムをドラッグ可能にするかどうか
					itemAddOptions: {
						enabled: true, // add a button to board for easy item creation
						content: '+', // text or html content of the board button
						class: 'kanban-title-button btn btn-default btn-xs', // default class of the button
						footer: true // position the button on footer
					},


					click : function (el) {}, // callback when any board's item are clicked
					context : function (el, event) {}, // callback when any board's item are right clicked
					dragEl : function (el, source) {}, // callback when any board's item are dragged
					dragendEl : function (el) {}, // callback when any board's item stop drag
					dropEl : function (el, target, source, sibling) {
						var sourceId = $(source).closest("div.kanban-board").attr("data-id"),
						targetId = $(target).closest("div.kanban-board").attr("data-id"),
						elId = $(el).closest("div.kanban-item").attr("data-eid");
						console.log({
							task_id: splitEnd(elId, '-'),
							board_id: splitEnd(targetId, '-')
						})
						let url = '{{ route("task.update", ":id") }}';
						url = url.replace(':id', splitEnd(elId, '-'));
						console.log(url)
						$.ajax({
							url,
							method: 'PATCH',
							data: {
								_token: '{{ csrf_token() }}',
								board_id: splitEnd(targetId, '-')
							},
							success: function(res){
								console.log(res);
							},
							error: function(err){
								console.log(err)
							}
						})
					}, // callback when any board's item drop in a board
					dragBoard : function (el, source) {}, // callback when any board stop drag
					dragendBoard : function (el) {}, // callback when any board stop drag
					buttonClick : function(el, boardId) {}, // callback when the board's button is clicked
					propagationHandlers: [],
				});
				
				$('#tambah').click(function(){
					console.log(kanban.addElement('column-id-1', {'title':'Test Add'}, 0))
				}) 

				document.querySelectorAll('.kanban-item').forEach(item => {
					if (item.dataset.class) {
						item.classList.add(item.dataset.class);
					}

				
				});


			},
			error: function (err){

			}
		})
</script>
@endpush