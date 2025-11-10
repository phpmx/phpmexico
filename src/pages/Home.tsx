import React from 'react'
import { Button } from '@/components/ui/button'
import { Card } from '@/components/ui/card'
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from '@/components/ui/accordion'
import {
  Twitter,
  Facebook,
  Instagram,
  Youtube,
  Slack,
  Code,
  Database,
  Server,
  Brush,
  Layers,
  ShoppingBag,
  Component,
} from 'lucide-react'

// --- Componente Hero ---
const HeroSection = () => (
  <section className="flex min-h-[60vh] flex-col items-center justify-center px-4 py-12 text-center md:py-20">
    <div className="container mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
      <div className="mb-8 flex justify-center">
        <img 
          src="/logo.png" 
          srcSet="/logo.png 1x, /logo@2x.png 2x, /logo@3x.png 3x"
          alt="PHP Mexico Logo" 
          className="h-40 w-40 md:h-48 md:w-48 lg:h-56 lg:w-56"
          width="224"
          height="224"
        />
      </div>
      <h1 className="mb-4 text-4xl font-bold md:text-6xl">
        La comunidad de PHP en México
      </h1>
      <p className="mb-8 text-lg text-muted-foreground">
        Conéctate con desarrolladores de todo el país
      </p>
      <div className="flex justify-center space-x-4">
         <Button variant="outline" size="icon" asChild>
          <a href="https://join.slack.com/t/phpmx/shared_invite/zt-3a188halw-o05hyFNG~qEmW9Ci_g1kuQ" target="_blank" rel="noopener noreferrer">
            <Slack className="h-5 w-5" />
            <span className="sr-only">Slack</span>
          </a>
        </Button>
        
        <Button variant="outline" size="icon" asChild>
          <a href="https://twitter.com/phpmx" target="_blank" rel="noopener noreferrer">
            <Twitter className="h-5 w-5" />
            <span className="sr-only">Twitter</span>
          </a>
        </Button>
        <Button variant="outline" size="icon" asChild>
          <a href="https://www.facebook.com/pehacheperos" target="_blank" rel="noopener noreferrer">
            <Facebook className="h-5 w-5" />
            <span className="sr-only">Facebook</span>
          </a>
        </Button>
        <Button variant="outline" size="icon" asChild>
          <a href="https://www.instagram.com/phpmx/" target="_blank" rel="noopener noreferrer">
            <Instagram className="h-5 w-5" />
            <span className="sr-only">Instagram</span>
          </a>
        </Button>
        <Button variant="outline" size="icon" asChild>
          <a href="https://www.youtube.com/@phpmexico" target="_blank" rel="noopener noreferrer">
            <Youtube className="h-5 w-5" />
            <span className="sr-only">YouTube</span>
          </a>
        </Button>
      </div>
    </div>
  </section>
)

// --- Componente de Tecnologías ---
const techList = [
  { name: 'Symfony', icon: <Code /> },
  { name: 'Laravel', icon: <Code /> },
  { name: 'Yii', icon: <Code /> },
  { name: 'Slim', icon: <Code /> },
  { name: 'ExpressJs', icon: <Code /> },
  { name: 'Zend', icon: <Code /> },
  { name: 'Sass', icon: <Brush /> },
  { name: 'ReactJs', icon: <Component /> },
  { name: 'AngularJs', icon: <Component /> },
  { name: 'MySQL', icon: <Database /> },
  { name: 'PostgreSQL', icon: <Database /> },
  { name: 'Oracle', icon: <Database /> },
  { name: 'SQL Server', icon: <Server /> },
  { name: 'Drupal', icon: <Layers /> },
  { name: 'WordPress', icon: <Layers /> },
  { name: 'Magento', icon: <ShoppingBag /> },
]

const TechnologiesSection = () => (
  <section id="tecnologias" className="bg-muted py-20">
    <div className="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <h2 className="mb-2 text-center text-3xl font-bold">Tecnologías</h2>
      <p className="mb-10 text-center text-muted-foreground">
        Frameworks y herramientas que usamos en la comunidad
      </p>
      <div className="grid grid-cols-2 gap-4 md:grid-cols-4 lg:grid-cols-8">
        {techList.map((tech) => (
          <Card key={tech.name} className="flex flex-col items-center justify-center p-4 transition-all hover:shadow-lg">
            {/* REEMPLAZAR: 
              Este es un placeholder. Usa tu <img src="..." /> para cada logo.
              La imagen que adjuntaste (image_22b68b.png) es una captura de pantalla.
            */}
            <div className="mb-2 text-muted-foreground grayscale transition-all hover:grayscale-0">
              {React.cloneElement(tech.icon, { size: 32 })}
            </div>
            <p className="text-sm font-medium">{tech.name}</p>
          </Card>
        ))}
      </div>
    </div>
  </section>
)

// --- Componente de FAQ ---
const faqItems = [
  {
    q: '¿Cómo puedo contribuir a la comunidad PHP México?',
    a: 'Puedes contribuir...',
  },
  {
    q: '¿Necesito ser un experto en PHP para unirme?',
    a: 'No, todos son bienvenidos...',
  },
  {
    q: '¿Cómo puedo proponer una charla o taller?',
    a: 'Ponte en contacto con los organizadores...',
  },
  {
    q: '¿Hay oportunidades de networking y empleo?',
    a: 'Sí, en nuestra bolsa de trabajo y eventos...',
  },
  {
    q: '¿Cómo puedo mantenerme actualizado con los eventos?',
    a: 'Síguenos en nuestras redes sociales...',
  },
  {
    q: '¿Puedo organizar un evento local en mi ciudad?',
    a: '¡Claro! Contáctanos para ayudarte...',
  },
]

const FaqSection = () => (
  <section id="faq" className="py-20">
    <div className="container mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
      <h2 className="mb-2 text-center text-3xl font-bold">
        Preguntas Frecuentes
      </h2>
      <p className="mb-10 text-center text-muted-foreground">
        Todo lo que necesitas saber sobre cómo contribuir y participar en la
        comunidad
      </p>
      <Accordion type="single" collapsible className="w-full">
        {faqItems.map((item) => (
          <AccordionItem value={item.q} key={item.q}>
            <AccordionTrigger>{item.q}</AccordionTrigger>
            <AccordionContent>{item.a}</AccordionContent>
          </AccordionItem>
        ))}
      </Accordion>
    </div>
  </section>
)

// --- Página Principal ---
export default function Home() {
  return (
    <>
      <HeroSection />
      <TechnologiesSection />
      <FaqSection />
    </>
  )
}