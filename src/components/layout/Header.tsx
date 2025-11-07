import { Link } from 'react-router-dom'
import { Button } from '@/components/ui/button'
import {
  Sheet,
  SheetContent,
  SheetClose,
  SheetTrigger,
  SheetTitle,
  SheetDescription,
} from '@/components/ui/sheet'
import { Menu } from 'lucide-react'

const navLinks = [
  { href: '/', label: 'Comunidad' },
  { href: '/eventos', label: 'Eventos' },
]

export default function Header() {
  return (
    <header className="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
      <div className="container flex h-14 items-center">
        {/* --- 1. Logo (Izquierda) --- */}
        <div className="mr-4 flex">
          <Link to="/" className="mr-6 flex items-center space-x-2">
            {/* TODO: Reemplazar esto por tu logo SVG o <img> */}
            <span className="font-bold">PHP Mexico</span>
          </Link>
        </div>

        {/* --- 2. Navegación de Escritorio (Centro/Izquierda) --- */}
        <nav className="hidden items-center space-x-6 text-sm font-medium md:flex">
          {navLinks.map((link) => (
            <Link
              key={link.href}
              to={link.href}
              className="text-foreground/60 transition-colors hover:text-foreground/80"
            >
              {link.label}
            </Link>
          ))}
        </nav>

        {/* --- 3. Espaciador (Empuja el menú móvil a la derecha) --- */}
        <div className="flex-1" />

        {/* --- 4. Menú Móvil (Derecha) --- */}
        <div className="md:hidden">
          <Sheet>
            <SheetTrigger asChild>
              <Button variant="outline" size="icon">
                <Menu className="h-4 w-4" />
                <span className="sr-only">Abrir menú</span>
              </Button>
            </SheetTrigger>
            <SheetContent side="right">
              <SheetTitle>Menú de navegación</SheetTitle>
              <SheetDescription>
                Navega por las diferentes secciones de PHP Mexico
              </SheetDescription>
              {/* Contenido del menú lateral */}
              <nav className="flex flex-col space-y-4 pt-6">
                <Link to="/" className="mb-4 flex items-center space-x-2">
                  <span className="font-bold">PHP Mexico</span>
                </Link>

                {navLinks.map((link) => (
                  <SheetClose asChild key={link.href}>
                    <Link
                      to={link.href}
                      className="text-lg font-medium text-foreground/80 transition-colors hover:text-foreground"
                    >
                      {link.label}
                    </Link>
                  </SheetClose>
                ))}
              </nav>
            </SheetContent>
          </Sheet>
        </div>

        {/* Los botones de Login/Register han sido eliminados */}
      </div>
    </header>
  )
}