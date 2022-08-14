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

		/* ===== Scrollbar CSS ===== */
		/* Firefox */
		
		
	</style>
@endsection

@section('content')
	<div class="card">
		<div class="card-header"><h4>Task</h4></div>
	</div>
	<div class="mb-3">
		<button type="button" data-toggle="modal" data-target="#createBoard" class="btn btn-primary">Tambah Board</button>
		<button type="button" class="btn btn-primary" id="tambah">Tambah Task</button>
		@empty($defaultTemplate)
		<button type="button" class="btn btn-success " id="generateDefault">Generate Default Template</button>
		@endempty
		<form action="{{ route('project.board.storeDefault', $projectId) }}" method="post" id="generateDefaultForm">
			@csrf
		</form>
	</div>
	<div id="kanban-canvas" class="pb-5" style="overflow-x: auto">
	<!-- ここにカンバンが表示される -->
</div>
@endsection


@push('modals')
	<div class="modal fade" id="createBoard" tabindex="-1" aria-labelledby="createBoardLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form action="{{ route('project.board.store', $projectId) }}" method="post" id="formAddBoard">
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
						<button type="submit" class="btn btn-primary">Tambah</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="modal fade" id="detailTask" data-backdrop="static" data-keyboard="false" tabindex="-1"
		aria-labelledby="detailTaskLabel" aria-hidden="true">
		<div class="modal-dialog  modal-lg">
			<form action="" method="post">
				@csrf
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="detailTaskLabel"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="">Created By: <b></b></label>
						</div>
						<div class="form-group">
							<label for="">Deskripsi</label>
							<textarea class="form-control" name="description" id="" cols="30" rows="10" style="height: 100px;"  readonly></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endpush

@push('scripts')
<script src="{{ asset('js/jkanban.min.js') }}"></script>
<script src="https://unpkg.com/@mattlewis92/dom-autoscroller@2.4.2/dist/dom-autoscroller.min.js"></script>
<script>
		console.log(toastr);
		// Modal Detail Task Kanban
		$('#detailTask').on('click', 'textarea', function(){
			console.log($(this).prop('readonly', false));
			$('#detailTask button[type=submit]').show()
		})
		
		$('#detailTask form').submit(function(){
			event.preventDefault();
			const data = $(this).serialize();

			$.ajax({
				url: $(this).attr('action'),
				method: 'patch',
				data,
				dataType: 'json',
				success: function(res){
					console.log(localStorage.getItem('lastElement'))
					if(res.success){
						$(JSON.parse(localStorage.getItem('lastElement'))).attr('data-description', $('#detailTask textarea').val())
						$('#detailTask').modal('hide');
						toastr.success("Berhasil mengupdate task", 'Success');
					}
				}
			})
		})
		

		$('#formAddBoard').submit(function(){
			event.preventDefault()

			const data  = $(this).serializeArray();
			data.push({name: '_token', value: '{{ csrf_token() }}', })
			data.push({name: 'order', value: $('.kanban-board').length + 1, })
			
			$.ajax({
				url: $(this).attr('action'),
				method: 'POST',
				data,
				success: function(res){
					console.log(res);
					if(res.success){
						location.reload()
					}
				},
				error: function(err){
					console.log(err);
				}
			})
		})

		const splitEnd = function(Data, Separator) {
			const Array = Data.split(Separator);
			
			return Array[Array.length - 1];
		}

		function clickHandle(el){
			localStorage.setItem('lastElement', JSON.stringify(el));
			const id = splitEnd($(el).attr('data-eid'), '-');
			let url = "{{ route('task.update', ':id') }}";
			url = url.replace(':id', id)
			$('#detailTaskLabel').html($(el).attr('data-name'))
			$('#detailTask form').attr('action', url)
			$('#detailTask textarea').prop('readonly', true);
			$('#detailTask b').html($(el).attr('data-createdBy'));
			$('#detailTask button[type=submit]').hide()
			$('#detailTask textarea').val($(el).attr('data-description'))
			$('#detailTask').modal('show');
		}

		$('#generateDefault').click(function(){
			$('#generateDefaultForm').submit();
		})

		$.ajax({
			url: window.location.href,
			method: 'GET',
			cache: false,
			success: function(res){
				const dataContent = mapResKanban(res)
				const kanban = new jKanban({
					
					element: '#kanban-canvas', // カンバンを表示する場所のID
					boards: dataContent, // カンバンに表示されるカラムやカードのデータ
					gutter: '16px', // カンバンの余白
					widthBoard: '275px', // カラムの幅 (responsivePercentageの「true」設定により無視される)
					// responsivePercentage: true, // trueを選択時はカラム幅は％で指定され、gutterとwidthBoardの設定は不要
					dragItems: true, // trueを選択時はカードをドラッグ可能
					dragBoards: true, // カラムをドラッグ可能にするかどうか
					itemAddOptions: {
						enabled: true, // add a button to board for easy item creation
						content: ' ', // text or html content of the board button
						class: 'fas fa-trash btn btn-danger btn-sm', // default class of the button
						footer: true // position the button on footer
					},
					click : function (el) {
						clickHandle(el);
					}, 
					context : function (el, event) {
						const id = splitEnd($(el).attr('data-eid'), '-');

						Swal.fire({
							title: 'Are you sure?',
							text: "You won't be able to revert this!",
							icon: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Yes, delete it!'
						}).then((result) => {
							let url = '{{ route("task.destroy", ":id") }}';
							url = url.replace(':id', id);

							if (result.isConfirmed) {
								$.ajax({
									url,
									method: 'delete',
									data: {
										_token: '{{ csrf_token() }}'
									},
									success: function(res){
										kanban.removeElement($(el).attr('data-eid'));
										if(res.success){
											toastr.success('Berhasil menghapus Task', 'Success');
										}
									},
									error: function(err){
										console.log(err);
									}
								})
							}
						})
						console.log([el, event]);
					}, 
					dragEl : function (el, source) {},
					dragendEl : function (el) {}, 
					dropEl : function (el, target, source, sibling) {
						dropElHandle(el, target, source, sibling);
					}, // callback when any board's item drop in a board
					dragBoard : function (el, source) {
						localStorage.setItem('lastOrder', $(el).attr('data-order'));
					}, // callback when any board stop drag
					dragendBoard : function (el) {
						dragendBoardHandle(el)
					
					}, // callback when any board stop drag
					buttonClick : function(el, boardId) {
						let url = '{{ route("project.board.destroy", [$projectId, ":id"]) }}';
						url = url.replace(":id", splitEnd(boardId, '-'))

						Swal.fire({
							title: 'Are you sure?',
							text: "You won't be able to revert this!",
							icon: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Yes, delete it!'
						}).then((result) => {
							if (result.isConfirmed) {
								$.ajax({
									url,
									method: 'delete',
									data: {_token: '{{ csrf_token() }}'},
									success: function(res){
										if(res.success){
											kanban.removeBoard(boardId);
											toastr.success(res.message, 'Berhasil')
										}
									},
									error: function(err){
										console.log(err)
									}
								})
							}
						})
						
					}, // callback when the board's button is clicked
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
							$.ajax({
								url: '{{ route("task.store") }}',
								method: 'POST',
								data: {
									_token: '{{ csrf_token() }}',
									user_id: '{{ auth()->id() }}',
									board_id: splitEnd(targetId, '-'),
									name: result.value
								},
								cache: false,
								success: function(res){
									console.log(result)
									if(res.success){
										const obj = {
											'id': res.data.id,
											'title': result.value,
											"name": result.value,
											"createdBy": '{{ auth()->user()->name }}',
											"description": '-'
										};

										kanban.addElement(targetId, obj, 0);
										toastr.success('Berhasil menambahkan Board', 'success')
									}
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

		function dropElHandle (el, target, source, sibling){
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
		}

		function dragendBoardHandle (el){
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
		}

		function mapResKanban(res){
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
						"title": val.name,
						"name": val.name,
						"createdBy": val.user.name,
						"description": val.description ?? '-'
					});
					
				})
				dataContent.push(obj);
			})

			return dataContent;
		}

</script>

<script>
	
</script>
@endpush