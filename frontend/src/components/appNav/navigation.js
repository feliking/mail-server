export const nav = [
  {
    title: 'Principal',
    icon: 'home',
    to: { name: 'index' }
  },
  {
    title: 'Notificaciones',
    icon: 'sms',
    children: [
      {
        title: 'Correo electrónico',
        icon: 'mail',
        to: { name: 'mail' }
      }
    ]
  }
]
