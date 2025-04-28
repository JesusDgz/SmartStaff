<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const role = ref('')
const error = ref('')
const loading = ref(false)
const router = useRouter()

const roles = ['Administrador', 'Cliente', 'Mesero', 'Caja']

const login = async () => {
  error.value = ''
  loading.value = true

  try {
    if (!role.value) throw new Error('Debes seleccionar un rol')

    // Simulación de login (reemplaza por tu API)
    await new Promise(resolve => setTimeout(resolve, 1000))

    if (email.value === 'admin@restaurante.com' && password.value === '123456') {
      router.push('/dashboard') // Redirige según el rol si quieres
    } else {
      throw new Error('Correo o contraseña incorrectos')
    }
  } catch (err) {
    error.value = err.message
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <v-container class="fill-height login-bg" fluid>
    <v-row  justify="center">
      <v-col cols="12" sm="8" md="5" lg="4">
        <v-card class="pa-6 rounded-xl" elevation="10">
          <v-card-title class="text-center text-h5 mb-4">
            🍽️ Bienvenido al Sistema del Restaurante
          </v-card-title>
          <v-card-text>
            <v-form @submit.prevent="login">
              <v-select
                v-model="role"
                :items="roles"
                label="Rol"
                prepend-inner-icon="mdi-account-badge-outline"
                required
              ></v-select>

              <v-text-field
                v-model="email"
                label="Correo"
                prepend-inner-icon="mdi-email-outline"
                type="email"
                required
              ></v-text-field>

              <v-text-field
                v-model="password"
                label="Contraseña"
                prepend-inner-icon="mdi-lock-outline"
                type="password"
                required
              ></v-text-field>

              <v-alert v-if="error" type="error" dense class="mt-2">{{ error }}</v-alert>

              <v-btn
                type="submit"
                color="deep-purple-accent-4"
                class="mt-4"
                block
                size="large"
                :loading="loading"
              >
                Iniciar como {{ role || '...' }}
              </v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped>
.login-bg {
  background: linear-gradient(to bottom right, #ffebee, #e8eaf6);
}
</style>
