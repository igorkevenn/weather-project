import useHttp from '@/composables/Api/useHttp'
import type { HistoryData } from '@/types/Api/weather.type'

export default function useHistory() {
  const { loading, error, get, del } = useHttp()

  async function list(limit = 5) {
    return get<HistoryData>(`/api/history?limit=${limit}`)
  }

  async function remove(id: number) {
    return del(`/api/history/${id}`)
  }

  return { loading, error, list, remove }
}
