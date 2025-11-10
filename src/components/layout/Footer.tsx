import { Link } from 'react-router-dom'
import { Button } from '@/components/ui/button'
import { Twitter, Facebook, Instagram, Youtube, Calendar } from 'lucide-react'

export default function Footer() {
  return (
    <footer className="border-t">
      <div className="container grid grid-cols-1 gap-8 py-14 md:grid-cols-4">
        <div>
          <h4 className="mb-2 text-lg font-semibold">PHP Mexico</h4>
          <p className="text-sm text-muted-foreground">
            La comunidad de desarrolladores PHP en México
          </p>
        </div>
        <div>
          <h4 className="mb-2 font-semibold">Comunidad</h4>
          <ul className="space-y-2 text-sm">
            <li>
              <Link
                to="/eventos"
                className="text-muted-foreground hover:text-foreground"
              >
                Eventos
              </Link>
            </li>
            <li>
              <a
                href="https://join.slack.com/t/phpmx/shared_invite/zt-3a188halw-o05hyFNG~qEmW9Ci_g1kuQ"
                target="_blank"
                rel="noopener noreferrer"
              >
                Unirme
              </a>
            </li>
          </ul>
        </div>
        <div>
          <h4 className="mb-2 font-semibold">Recursos</h4>
          <ul className="space-y-2 text-sm">
            <li>
              <a href="/#faq" className="text-muted-foreground hover:text-foreground">
                FAQ
              </a>
            </li>
            <li>
              <a
                href="/#tecnologias"
                className="text-muted-foreground hover:text-foreground"
              >
                Tecnologías
              </a>
            </li>
          </ul>
        </div>
        <div>
          <h4 className="mb-2 font-semibold">Síguenos</h4>
          <div className="flex flex-wrap gap-2">
            <Button variant="outline" size="icon" asChild>
              <a href="https://twitter.com/phpmx" target="_blank" rel="noopener noreferrer">
                <Twitter className="h-4 w-4" />
                <span className="sr-only">Twitter</span>
              </a>
            </Button>
            <Button variant="outline" size="icon" asChild>
              <a href="https://www.facebook.com/phpmx" target="_blank" rel="noopener noreferrer">
                <Facebook className="h-4 w-4" />
                <span className="sr-only">Facebook</span>
              </a>
            </Button>
            <Button variant="outline" size="icon" asChild>
              <a href="https://www.instagram.com/phpmx/" target="_blank" rel="noopener noreferrer">
                <Instagram className="h-4 w-4" />
                <span className="sr-only">Instagram</span>
              </a>
            </Button>
            <Button variant="outline" size="icon" asChild>
              <a href="https://www.youtube.com/@phpmexico" target="_blank" rel="noopener noreferrer">
                <Youtube className="h-4 w-4" />
                <span className="sr-only">YouTube</span>
              </a>
            </Button>
            <Button variant="outline" size="icon" asChild>
              <a href="https://www.meetup.com/es-ES/PHP-The-Right-Way/" target="_blank" rel="noopener noreferrer">
                <Calendar className="h-4 w-4" />
                <span className="sr-only">Meetup</span>
              </a>
            </Button>
          </div>
        </div>
      </div>
      <div className="border-t">
        <div className="container flex py-6 text-sm text-muted-foreground">
          © {new Date().getFullYear()} PHP Mexico. Todos los derechos reservados.
        </div>
      </div>
    </footer>
  )
}