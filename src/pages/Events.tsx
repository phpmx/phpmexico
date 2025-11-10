import { useState, useEffect } from 'react'
import axios from 'axios'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { ExternalLink, Youtube, Loader2, Calendar, Users } from 'lucide-react'

interface YouTubeVideo {
  id: string
  title: string
  thumbnail: string
  url: string
  publishedAt: string
}

export default function Events() {
  const [videos, setVideos] = useState<YouTubeVideo[]>([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    const fetchYouTubeVideos = async () => {
      try {
        const API_KEY = import.meta.env.VITE_YOUTUBE_API_KEY
        const CHANNEL_ID = import.meta.env.VITE_YOUTUBE_CHANNEL_ID
        console.log('Using YouTube API Key:', API_KEY)
        if (!API_KEY || API_KEY === 'YOUR_API_KEY_HERE') {
          setError('YouTube API key no configurada')
          setLoading(false)
          return
        }

        const response = await axios.get(
          'https://www.googleapis.com/youtube/v3/search',
          {
            params: {
              key: API_KEY,
              channelId: CHANNEL_ID,
              part: 'snippet',
              order: 'date',
              maxResults: 10,
              type: 'video',
            },
          }
        )

        const videoData: YouTubeVideo[] = response.data.items.map((item: any) => ({
          id: item.id.videoId,
          title: item.snippet.title,
          thumbnail: item.snippet.thumbnails.high.url,
          url: `https://www.youtube.com/watch?v=${item.id.videoId}`,
          publishedAt: item.snippet.publishedAt,
        }))

        setVideos(videoData)
        setLoading(false)
      } catch (err) {
        console.error('Error fetching YouTube videos:', err)
        setError('Error al cargar los videos')
        setLoading(false)
      }
    }

    fetchYouTubeVideos()
  }, [])

  return (
    <div className="container mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
      {/* Banner de invitación a Meetup */}
      <div className="mb-12 overflow-hidden rounded-2xl bg-gradient-to-br from-primary/10 via-primary/5 to-background border border-primary/20">
        <div className="flex flex-col items-center gap-6 p-8 text-center md:flex-row md:text-left">
          <div className="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-primary/10">
            <Calendar className="h-10 w-10 text-primary" />
          </div>
          <div className="flex-1">
            <h2 className="mb-2 text-2xl font-bold">¡Únete a nuestros eventos!</h2>
            <p className="mb-4 text-muted-foreground">
              Participa en charlas, talleres y networking con la comunidad PHP más grande de México. 
              Mantente al tanto de los próximos eventos presenciales y virtuales.
            </p>
            <Button size="lg" asChild>
              <a
                href="https://www.meetup.com/es-ES/PHP-The-Right-Way/"
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center gap-2"
              >
                <Users className="h-5 w-5" />
                Ver próximos eventos en Meetup
                <ExternalLink className="h-4 w-4" />
              </a>
            </Button>
          </div>
        </div>
      </div>

      <div className="mb-8">
        <h1 className="mb-2 text-3xl font-bold">Videos de Eventos Anteriores</h1>
        <p className="text-muted-foreground">
          Revive las mejores charlas y talleres de nuestra comunidad
        </p>
        <Button variant="outline" className="mt-4" asChild>
          <a
            href="https://www.youtube.com/@phpmexico"
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center gap-2"
          >
            <Youtube className="h-4 w-4" />
            Ver canal completo
            <ExternalLink className="h-3 w-3" />
          </a>
        </Button>
      </div>

      {loading && (
        <div className="flex items-center justify-center py-20">
          <Loader2 className="h-8 w-8 animate-spin text-muted-foreground" />
        </div>
      )}

      {error && (
        <div className="rounded-lg border border-destructive/50 bg-destructive/10 p-6 text-center">
          <p className="text-destructive">{error}</p>
          <p className="mt-2 text-sm text-muted-foreground">
            Por favor, configura tu YouTube API key en el archivo .env.local
          </p>
        </div>
      )}

      {!loading && !error && videos.length > 0 && (
        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {videos.map((video) => (
            <Card key={video.id} className="overflow-hidden transition-shadow hover:shadow-lg">
              <a
                href={video.url}
                target="_blank"
                rel="noopener noreferrer"
                className="block"
              >
                <div className="aspect-video w-full overflow-hidden bg-muted">
                  <img
                    src={video.thumbnail}
                    alt={video.title}
                    className="h-full w-full object-cover transition-transform hover:scale-105"
                  />
                </div>
                <CardHeader>
                  <CardTitle className="line-clamp-2 text-base">
                    {video.title}
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <p className="text-sm text-muted-foreground">
                    {new Date(video.publishedAt).toLocaleDateString('es-MX', {
                      year: 'numeric',
                      month: 'long',
                      day: 'numeric',
                    })}
                  </p>
                </CardContent>
              </a>
            </Card>
          ))}
        </div>
      )}

      {!loading && !error && videos.length === 0 && (
        <div className="py-20 text-center">
          <Youtube className="mx-auto mb-4 h-12 w-12 text-muted-foreground" />
          <h3 className="mb-2 text-lg font-semibold">No hay videos disponibles</h3>
          <p className="text-muted-foreground">
            Pronto estarán disponibles las grabaciones de nuestros eventos
          </p>
        </div>
      )}
    </div>
  )
}