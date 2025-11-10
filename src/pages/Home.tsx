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
} from 'lucide-react'

const urlBase = import.meta.env.BASE_URL;

const HeroSection = () => (
  <section className="flex min-h-[60vh] flex-col items-center justify-center px-4 py-12 text-center md:py-20">
    <div className="container mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
      <div className="mb-8 flex justify-center">
        <img
          src={`${urlBase}logo.png`}
          srcSet={`${urlBase}logo.png 1x, ${urlBase}logo@2x.png 2x, ${urlBase}logo@3x.png 3x`}
          alt="PHP Mexico Logo"
          className="h-40 w-40 md:h-48 md:w-48 lg:h-56 lg:w-56 object-contain"
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
          <a href="https://twitter.com/phpmx" target="_blank" rel="noopener noreferrer">
            <Twitter className="h-5 w-5" />
            <span className="sr-only">Twitter</span>
          </a>
        </Button>
        <Button variant="outline" size="icon" asChild>
          <a href="https://www.facebook.com/phpmx" target="_blank" rel="noopener noreferrer">
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

const techList = [
  { name: 'Symfony', logo: `${urlBase}logos/symfony.svg` },
  { name: 'Laravel', logo: `${urlBase}logos/laravel.svg` },
  { name: 'Yii', logo: `${urlBase}logos/yii.svg` },
  { name: 'Slim', logo: `${urlBase}logos/slim.svg` },
  { name: 'ExpressJs', logo: `${urlBase}logos/express.svg` },
  { name: 'Laminas', logo: `${urlBase}logos/laminas-wordmark.svg` },
  { name: 'Sass', logo: `${urlBase}logos/sass.svg` },
  { name: 'ReactJs', logo: `${urlBase}logos/react.svg` },
  { name: 'Angular', logo: `${urlBase}logos/angular.svg` },
  { name: 'MySQL', logo: `${urlBase}logos/mysql.svg` },
  { name: 'PostgreSQL', logo: `${urlBase}logos/postgresql.svg` },
  { name: 'Oracle', logo: `${urlBase}logos/oracle.svg` },
  { name: 'SQL Server', logo: `${urlBase}logos/microsoftsqlserver.svg` },
  { name: 'Drupal', logo: `${urlBase}logos/drupal.svg` },
  { name: 'WordPress', logo: `${urlBase}logos/wordpress.svg` },
  { name: 'Magento', logo: `${urlBase}logos/magento.svg` },
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
            <div className="mb-2 h-12 w-12 grayscale transition-all hover:grayscale-0">
              <img 
                src={tech.logo} 
                alt={`${tech.name} logo`}
                className="h-full w-full object-contain"
              />
            </div>
            <p className="text-sm font-medium">{tech.name}</p>
          </Card>
        ))}
      </div>
    </div>
  </section>
)

const faqItems = [
  {
    q: '¿Cómo puedo contribuir a la comunidad PHP México?',
    a: 'Hay muchas formas de contribuir: participa en nuestros eventos y meetups, comparte tu conocimiento en el Slack, ayuda a otros desarrolladores con sus dudas, escribe artículos técnicos, o propón charlas para nuestros eventos. Toda contribución, grande o pequeña, es valiosa para la comunidad.',
  },
  {
    q: '¿Necesito ser un experto en PHP para unirme?',
    a: '¡Para nada! La comunidad PHP México está abierta a desarrolladores de todos los niveles. Desde principiantes hasta expertos, todos son bienvenidos. Es un excelente lugar para aprender, hacer preguntas y crecer profesionalmente.',
  },
  {
    q: '¿Cómo puedo proponer una charla o taller?',
    a: 'Si tienes una idea para una charla o taller, puedes proponerla a través de nuestro Slack en el canal de eventos, o contactando directamente a los organizadores. Buscamos contenido técnico, casos de uso reales, y experiencias que puedan beneficiar a la comunidad.',
  },
  {
    q: '¿Hay oportunidades de networking y empleo?',
    a: 'Sí, la comunidad es un excelente lugar para hacer networking. Muchas empresas buscan talento PHP a través de nuestra red. Además, compartimos ofertas de trabajo en nuestros canales y durante los eventos. Es una gran oportunidad para conectar con otros profesionales y empresas.',
  },
  {
    q: '¿Cómo puedo mantenerme actualizado con los eventos?',
    a: 'Únete a nuestro Slack para recibir notificaciones sobre próximos eventos, meetups y noticias de la comunidad. También publicamos actualizaciones en nuestras redes sociales (Twitter, Facebook, Instagram).',
  },
  {
    q: '¿Puedo organizar un evento local en mi ciudad?',
    a: '¡Absolutamente! Fomentamos la creación de grupos locales en diferentes ciudades de México. Si quieres organizar un meetup o evento en tu ciudad, contáctanos a través del Slack y te ayudaremos con recursos, promoción y conexión con otros miembros locales.',
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
            <AccordionContent className="text-muted-foreground">
              {item.a}
            </AccordionContent>
          </AccordionItem>
        ))}
      </Accordion>
    </div>
  </section>
)

// --- Main page ---
export default function Home() {
  return (
    <>
      <HeroSection />
      <TechnologiesSection />
      <FaqSection />
    </>
  )
}