import useHttp from '@/composables/Api/useHttp'
import type {
  AirPollutionData,
  City,
  CurrentWeatherData,
  ForecastData,
} from '@/types/Api/weather.type'

export default function useWeather() {
  const { loading, error, get } = useHttp()

  async function searchCities(query: string) {
    return get<City[]>(`/api/geocode?q=${encodeURIComponent(query)}`)
  }

  async function getCurrent(city: string) {
    return get<CurrentWeatherData>(`/api/weather?city=${encodeURIComponent(city)}`)
  }

  async function getForecast(city: string) {
    return get<ForecastData>(`/api/forecast?city=${encodeURIComponent(city)}`)
  }

  async function getAirPollution(city: string) {
    return get<AirPollutionData>(`/api/air-pollution?city=${encodeURIComponent(city)}`)
  }

  return {
    loading,
    error,
    searchCities,
    getCurrent,
    getForecast,
    getAirPollution,
  }
}
