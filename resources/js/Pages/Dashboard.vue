<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import "chessground/assets/chessground.base.css";
import "chessground/assets/chessground.brown.css";
import "chessground/assets/chessground.cburnett.css";

import { Chessground } from 'chessground';
import { onMounted, ref } from "vue";
import { Chess } from "chess.js"
import { Square } from "chessboardjs";
import { toDests } from "../utils/chess"

const board = ref<HTMLDivElement | null>(null);
const game = new Chess();

onMounted(() => {
	if (board.value == null) {
		console.error("Something went wrong loading chessboard")
		return;
	}


	const ground = Chessground(board.value, {
		movable: {
			color: 'white',
			free: false,
			dests: toDests(game),
		},
		draggable: {
			showGhost: true
		},
		events: {
			move(from, to) {

			},
		}
	})


	window.Echo.channel("move").listen("MoveEvent", (e) => {
		console.log("MoveEvent", e)
		ground.move(e.move.from, e.move.to)
	})
})



</script>

<template>
	<AppLayout title="Dashboard">
		<!-- <template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Dashboard
			</h2>
		</template> -->

		<div
			class="my-12 max-w-7xl justify-center items-center flex py-10 mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
			<div id="board" ref="board" style="width: 500px; height: 500px"></div>
		</div>
	</AppLayout>
</template>
