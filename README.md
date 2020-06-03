Ovveride base menu<br>
delta8:<br>
  menu: App\Menu\EximMenu
  
or register new instance in file service.yml<br>
App\Menu\EximMenu:<br>
  tags:
    - { name: evrinoma.menu }
 