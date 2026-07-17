export interface ApiEnvelope<T> {
  status: boolean
  data: T
}

export interface City {
  name: string
  lat: number
  lon: number
  country: string
  state: string | null
}

export interface Weather {
  city_name: string
  country: string
  lat: number
  lon: number
  temperature: number
  feels_like: number
  temp_min: number
  temp_max: number
  humidity: number
  pressure: number
  description: string
  icon: string
  wind_speed: number
  clouds: number
  visibility: number
}

export interface ForecastItem {
  datetime: string
  timestamp: number
  temperature: number
  feels_like: number
  temp_min: number
  temp_max: number
  humidity: number
  description: string
  icon: string
  wind_speed: number
  pop: number
}

export interface ForecastPayload {
  city: City
  list: ForecastItem[]
}

export interface AirPollution {
  aqi: number
  aqi_label: string
  components: Record<string, number>
}

export interface CurrentWeatherData {
  location: City
  weather: Weather
}

export interface ForecastData {
  location: City
  forecast: ForecastPayload
}

export interface AirPollutionData {
  location: City
  airPollution: AirPollution
}

export interface HistoryItem {
  id: number
  city_name: string
  temperature: number
  feels_like: number
  humidity: number
  description: string
  searched_at: string
}

export interface HistoryData {
  registers: HistoryItem[]
}
