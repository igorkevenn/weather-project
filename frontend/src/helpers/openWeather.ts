/**
 * Ícones de clima — CDN oficial da OpenWeather.
 */
export function weatherIconUrl(icon: string, retina = false): string {
  const suffix = retina ? '@2x' : ''
  return `https://openweathermap.org/img/wn/${icon}${suffix}.png`
}
