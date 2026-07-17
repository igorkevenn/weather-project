import { ref } from 'vue'
import type { AxiosRequestConfig } from 'axios'
import http from '@/plugins/axios'
import type { ApiEnvelope } from '@/types/Api/weather.type'

export default function useHttp() {
  const loading = ref(false)
  const error = ref<string | null>(null)

  async function get<T>(url: string, config?: AxiosRequestConfig): Promise<T | null> {
    loading.value = true
    error.value = null

    try {
      const { data } = await http.get<ApiEnvelope<T>>(url, config)

      if (!data.status) {
        const payload = data.data as { message?: string }
        error.value = payload?.message || 'Falha na requisição.'
        return null
      }

      return data.data
    } catch (err: unknown) {
      const axiosErr = err as { response?: { data?: { data?: { message?: string } } }; message?: string }
      error.value =
        axiosErr.response?.data?.data?.message ||
        axiosErr.message ||
        'Erro de conexão.'
      return null
    } finally {
      loading.value = false
    }
  }

  async function del<T>(url: string): Promise<T | null> {
    loading.value = true
    error.value = null

    try {
      const { data } = await http.delete<ApiEnvelope<T>>(url)

      if (!data.status) {
        const payload = data.data as { message?: string }
        error.value = payload?.message || 'Falha na requisição.'
        return null
      }

      return data.data
    } catch (err: unknown) {
      const axiosErr = err as { response?: { data?: { data?: { message?: string } } }; message?: string }
      error.value =
        axiosErr.response?.data?.data?.message ||
        axiosErr.message ||
        'Erro de conexão.'
      return null
    } finally {
      loading.value = false
    }
  }

  return { loading, error, get, del }
}
