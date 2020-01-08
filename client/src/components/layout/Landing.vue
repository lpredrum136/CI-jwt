<template>
	<b-jumbotron class="text-center" style="height: 100vh; margin-bottom: 0">
		<template v-slot:header>CI JWT</template>

		<template v-slot:lead>Json Web Token Implementation</template>

		<hr class="my-4" />

		<b-button variant="primary" to="/register" class="mr-2">Sign Up</b-button>
		<b-button variant="success" to="/login">Login</b-button>
	</b-jumbotron>
</template>

<script>
export default {
	name: 'Landing'
};
</script>

<style></style>
