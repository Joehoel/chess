<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import "chessground/assets/chessground.base.css";
import "chessground/assets/chessground.brown.css";
import "chessground/assets/chessground.cburnett.css";

import { Chessground } from 'chessground';
import { onMounted, ref } from "vue";
import { Chess } from "chess.js"
import { toColor, toDests } from "../../utils/chess"
import { router } from "@inertiajs/vue3";
import { Game } from "@/types/types";
import { Key, Piece } from "chessground/types";
import { computed } from "vue";
import { truncate } from "fs";
import { json } from "stream/consumers";

const { game, color } = defineProps<{ game: Game, color: 'black' | 'white' }>();

console.log({ color })

const el = ref<HTMLDivElement | null>(null);
const chess = new Chess();

const turn = computed(() => toColor(chess))


console.log(turn.value)

onMounted(() => {
	if (el.value == null) {
		console.error("Something went wrong loading chessboard")
		return;
	}


	const board = Chessground(el.value, {
		movable: {
			color: color === turn.value ? color : undefined,
			// color: movableColor.value,
			free: false,
			dests: toDests(chess),
		},
		draggable: {
			showGhost: true
		},
		events: {
			move(from, to) {
				console.log(from, to, toDests(chess), toDests(chess).get(from));
				router.post(`/game/${game.id}/move`, {
					from,
					to,
					// TODO reconsider giving the whole toDetst object due to validation for the from step
					possible_moves: JSON.stringify(toDests(chess).get(from)),
				}, { preserveScroll: true, replace: true }
				)
			}
		}
	})

console.log(`game.${game.id}`);

	window.Echo.channel(`game.${game.id}`)
	.listen("MoveEvent", (e: { game: { id: Game['id'] }, move: { from: Key, to: Key } }) => {
		console.log("MoveEvent", e.game, e.move);
		board.move(e.move.from, e.move.to);
	})
})



</script>

<template>
	<AppLayout out title="Dashboard">
		<div
			class="my-12 max-w-7xl justify-center items-center flex py-10 mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
			<div id="board" ref="el" style="width: 500px; height: 500px"></div>
		</div>
	</AppLayout>
</template>
