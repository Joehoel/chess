<script setup lang="ts">
import { Game } from '@/types/types';
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'

const form = useForm({
	name: "",
})



const props = defineProps<{ games: Game[] }>();

</script>


<template>
	<form @submit.prevent="form.post('/game')">
		<input type="text" v-model="form.name" placeholder="name">
		<input class="border border-gray-200 rounded-xl cursor-pointer px-3 py-2" type="submit" :disabled="form.processing"
			value="Create game">
	</form>

	<ul class="p-1 m-4">
		<li v-for="game in props.games" class="py-2 flex flex-row justify-between">
			<span>{{ game.name }} {{ game.player_count }}/2</span>
			<Link as="a" class="bg-green-400 p-2 rounded-xl text-white border border-green-500" :href="`/game/${game.id}/join`">
			Join
			</Link>
		</li>
	</ul>
</template>
