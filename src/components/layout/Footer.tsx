import { Link } from 'react-router-dom'
import { Button } from '@/components/ui/button'
import { Twitter, Facebook, Instagram, Github, Slack } from 'lucide-react'

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
              <Link to="/" className="text-muted-foreground hover:text-foreground">
                Empresas
              </Link>
            </li>
            {/* Link a "Bolsa de Trabajo" eliminado */}
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
                href="#" // TODO: Añadir link de Slack
                className="text-muted-foreground hover:text-foreground"
              >
                Chat (Slack)
              </a>
            </li>
          </ul>
        </div>
        <div>
          <h4 className="mb-2 font-semibold">Recursos</h4>
          <ul className="space-y-2 text-sm">
            <li>
              {/* Link de anclaje a la sección FAQ en la Home */}
              <a href="/#faq" className="text-muted-foreground hover:text-foreground">
                FAQ
              </a>
            </li>
            <li>
              {/* Link de anclaje a la sección Tecnologías en la Home */}
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
          <div className="flex space-x-2">
            <Button variant="outline" size="icon" asChild>
              <a href="#"> {/* TODO: Link Twitter */}
                <Twitter className="h-4 w-4" />
              </a>
            </Button>
            <Button variant="outline" size="icon" asChild>
              <a href="#"> {/* TODO: Link Facebook */}
                <Facebook className="h-4 w-4" />
              </a>
            </Button>
            <Button variant="outline" size="icon" asChild>
              <a href="#"> {/* TODO: Link Instagram */}
                <Instagram className="h-4 w-4" />
              </a>
            </Button>
            <Button variant="outline" size="icon" asChild>
              <a href="#"> {/* TODO: Link Github */}
                <Github className="h-4 w-4" />
              </a>
            </Button>
            {/* Logo de Slack añadido como solicitaste */}
            <Button variant="outline" size="icon" asChild>
              <a href="#"> {/* TODO: Link Slack */}
                <Slack className="h-4 w-4" />
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