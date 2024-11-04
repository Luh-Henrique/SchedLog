<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-white text-blue-600">
    <!-- Topo com logo -->
    <header class="w-full px-8 py-4">
      <img src="/images/logo/logo.png" alt="Logo SchedLog" class="h-24" /> <!-- Altere o caminho para o logo -->
    </header>

    <!-- Conteúdo principal -->
    <main class="flex-1 flex flex-col items-center justify-center text-center">
      <h1 class="text-4xl font-bold">Bem-vindo ao SchedLog</h1>
      <p class="mt-4 text-lg text-gray-600">Seu sistema de gestão de pátios</p>

      <!-- Botões de Login e Registrar (mantendo o padrão Laravel) -->
      <div class="mt-8">
        <a
          href="/login"
          class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-300"
        >
          Login
        </a>
        <a
          href="/register"
          class="ml-4 px-6 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-300"
        >
          Registrar
        </a>
      </div>
    </main>

    <!-- Rodapé -->
    <footer class="w-full px-8 py-4 text-center text-sm text-gray-500">
      &copy; 2024 SchedLog. Todos os direitos reservados.
    </footer>
  </div>
</template>

<script>
export default {
  name: 'WelcomePage',
};
</script>

<style scoped>
/* Adicione seu estilo customizado aqui, se necessário */
</style>
