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
		@empty($defaultTemplate)
		<button type="button" class="btn btn-success " id="generateDefault">Generate Default Template</button>
		@endempty
		<form action="{{ route('project.board.storeDefault', $projectId) }}" method="post" id="generateDefaultForm">
			@csrf
		</form>
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

		$('#generateDefault').click(function(){
			$('#generateDefaultForm').submit();
		})
		$.ajax({
			url: window.location.href,
			method: 'GET',
			cache: false,
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
				console.log(dataContent)
				const kanban = new jKanban({
					
					element: '#kanban-canvas', // カンバンを表示する場所のID
					boards: dataContent, // カンバンに表示されるカラムやカードのデータ
					gutter: '16px', // カンバンの余白
					widthBoard: '500px', // カラムの幅 (responsivePercentageの「true」設定により無視される)
					// responsivePercentage: true, // trueを選択時はカラム幅は％で指定され、gutterとwidthBoardの設定は不要
					dragItems: true, // trueを選択時はカードをドラッグ可能
					dragBoards: true, // カラムをドラッグ可能にするかどうか
					click : function (el) {}, // callback when any board's item are clicked
					context : function (el, event) {
						console.log([el, event]);
					}, // callback when any board's item are right clicked
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
							cache: false,
							success: function(res){
								console.log(res);
							},
							error: function(err){
								console.log(err)
							}
						})
					}, // callback when any board's item drop in a board
					dragBoard : function (el, source) {
						localStorage.setItem('lastOrder', $(el).attr('data-order'));
					}, // callback when any board stop drag
					dragendBoard : function (el) {
						const lastOrder = localStorage.getItem('lastOrder');
						const order = $(el).attr('data-order')
						var type;
						const boardId = splitEnd($(el).attr('data-id'), '-');

						if(lastOrder > order){
							type = 'increment';
						}else if(lastOrder < order){
							type = 'decrement';
						}else{
							type = false;
						}
						

						let url = '{{ route("project.board.update", [$projectId, ":id"]) }}'
						url = url.replace(':id', boardId);
						console.log(url)
						$.ajax({
							url,
							method: 'PATCH',
							data: {
								_token: '{{ csrf_token() }}',
								order,
								lastOrder,
								type,
							},
							cache: false,
							success: function(res){
								console.log(res);
							},
							error: function(err){
								console.log(err)
							}
						})

						
					}, // callback when any board stop drag
					buttonClick : function(el, boardId) {}, // callback when the board's button is clicked
					propagationHandlers: [],
				});
				
				$('#tambah').click(function(){
					const index = $($('.kanban-board')[0]).find('.kanban-item').length
					const targetId = $($('.kanban-board')[0]).attr('data-id');
					
					Swal.fire({
					title: 'Nama Task',
					input: 'text',
					showCancelButton: true,
					confirmButtonText: `Tambah`,
					}).then((result) => {
						if (result.isConfirmed) {
							console.log(targetId)
							kanban.addElement(targetId, {'title': result.value}, index)
							$.ajax({
								url: '{{ route("task.store") }}',
								method: 'POST',
								data: {
									_token: '{{ csrf_token() }}',
									board_id: splitEnd(targetId, '-'),
									name: result.value
								},
								cache: false,
								success: function(res){
									iziToast.success({
									title: 'success',
										message: 'Berhasil Menambahkan Task',
										position: 'topRight'
									});
									console.log(res);
								},
								error: function(err){
									console.log(err)
								}
							})
						} 
					});
					





					
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