@extends('layouts.noapp')

@section('title')
	Your Marketing Template
@endsection()

@section('content')
	<script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
<!-- or -->
<script src="https://unpkg.com/interactjs/dist/interact.min.js"></script>
	<div class="marketing-container">
		<div class="marketing-container-left">
			<div class="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)">
				<p ondragstart="dragStart(event)" ondrag="dragging(event)" draggable="true" id="dragtarget">Drag me!</p>
			</div>
			<div>Text</div>
		</div>
		<div class="marketing-container-center" class="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)">
			<div class="draggable"> Draggable Element </div>
		</div>
		<div class="marketing-container-right">sdf</div>
	</div>

	<style type="text/css">
		.marketing-container{
			max-width:1000px;
			margin: auto;
			display: flex;
		}

		.marketing-container-left,.marketing-container-right{
			width: 15%;
			background: green;
		}

		.marketing-container-center{
			width: 70%;
			background: red;
			overflow: hidden;
		}.draggable {
  touch-action: none;
  user-select: none;
}
	</style>
	<script type="text/javascript">
		const position = { x: 0, y: 0 }

interact('.draggable').draggable({
  listeners: {
    start (event) {
      console.log(event.type, event.target)
    },
    move (event) {
      position.x += event.dx
      position.y += event.dy

      event.target.style.transform =
        `translate(${position.x}px, ${position.y}px)`
    },
  }
})

function dragStart(event) {
  event.dataTransfer.setData("Text", event.target.id);
}

function dragging(event) {
  document.getElementById("demo").innerHTML = "The p element is being dragged";
}

function allowDrop(event) {
  event.preventDefault();
}

function drop(event) {
  event.preventDefault();
  var data = event.dataTransfer.getData("Text");
  event.target.appendChild(document.getElementById(data));
  event.className += "wtf";
}
	</script>
@endsection