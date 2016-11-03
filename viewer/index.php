<?php
	session_start();
	$target_dir = '../'.$_SESSION["DIRNAME"];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>three.js webgl - materials - cube reflection / refraction [Walt]</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<style>
			body {
				background:#000;
				color:#fff;
				padding:0;
				margin:0;
				overflow:hidden;
				font-family:georgia;
				text-align:center;
			}
			canvas { pointer-events:none; z-index:10; }
			#oldie { margin-top:11em !important }
		</style>
	</head>

	<body>
		<script src="js/three.js"></script>


		<script src="js/Detector.js"></script>

		<script>
			if ( ! Detector.webgl ) Detector.addGetWebGLMessage();
			var container;
			var camera, scene, renderer;
			var mesh, geometry;
			var pointLight;
			var mouseX = 0;
			var mouseY = 0;
			var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;
			document.addEventListener('mousemove', onDocumentMouseMove, false);
			init();
			animate();
			function init() {
				container = document.createElement( 'div' );
				document.body.appendChild( container );
				camera = new THREE.PerspectiveCamera( 50, window.innerWidth / window.innerHeight, 1, 5000 );
				camera.position.z = 2000;
				//
				//var path = "textures/cube/my/";
				var path = <?php echo json_encode($target_dir);?>;
				var format = '.jpg';
				var urls = [
						path + 'px' + format, path + 'nx' + format,
						path + 'py' + format, path + 'ny' + format,
						path + 'pz' + format, path + 'nz' + format
					];
				var reflectionCube = new THREE.CubeTextureLoader().load( urls );
				reflectionCube.format = THREE.RGBFormat;
				scene = new THREE.Scene();
				scene.background = reflectionCube;
				renderer = new THREE.WebGLRenderer();
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth, window.innerHeight );
				container.appendChild( renderer.domElement );
				window.addEventListener( 'resize', onWindowResize, false );
			}
			function onWindowResize() {
				windowHalfX = window.innerWidth / 2;
				windowHalfY = window.innerHeight / 2;
				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();
				renderer.setSize( window.innerWidth, window.innerHeight );
			}
			function onDocumentMouseMove(event) {
				mouseX = ( event.clientX - windowHalfX ) * 4;
				mouseY = ( event.clientY - windowHalfY ) * 4;
			}
			//
			function animate() {
				requestAnimationFrame( animate );
				render();
				
			}
			function render() {
				var timer = -0.0002 * Date.now();
				camera.position.x += ( mouseX - camera.position.x ) * .5;
				//camera.position.y += ( - mouseY - camera.position.y ) * .5;
				camera.lookAt( scene.position );
				renderer.render( scene, camera );
			}
		</script>

	</body>
</html>