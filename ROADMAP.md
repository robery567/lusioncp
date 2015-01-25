# LusionCP Development Roadmap
========
> **NOTA:** Acest roadmap este unul instabil. Se poate modifica oricand. Daca nu respecti acest roadmap, te asteapta :hocho: !!!

## LusionCP v1
========
- Default:
    - Nucleu:
        - Scris in stil procedural
        - Mici implementari ale OOP
    - User:
        - Statistici VPS
        - Backup local
        - Control server
        - Instalare serverfiles (!!! structura anume !!!)
        - Consola SSH
    - Admin:
        - Administrare utilizatori
        - Administrare serverfiles
- Update 1:
    - Nucleu:
        - Clasa pentru intretinerea erorilor
        - Clase ORM bazate pe PDO_MySQL si MySQLi
        - Utilizarea functiei ``build_url()`` pentru link-uri
        - Adaugare comanda ``unrar``
    - User:
        - Consola permite doar o lista de comenzi
        - Consola este blocata in directorul home (``/usr/home/metin2``)
    - Admin:
        - Sesiune multipla (conectare ca utilizator)
        - Poate vizualiza logurile
- Update 2:
    - Nucleu:
        - API pentru prelucrarea noutatilor
        - Cache intr-o baza de date SQLite
        - Compilarea sursei LusionCP (lcp_{versiune}.phar)
        - Utilizarea formei binare LusionCP
        - Implementarea sistemului de notificari
        - O mai buna organizare a fisierelor
    - User:
        - Poate sa-si vada logurile si IP-urile accesate
        - Utilizatorul poate sa extraga arhivele cu comanda ``unrar``
    - Admin:
        - Poate vedea noutatile cu privire la LusionCP
        - Poate adauga diverse anunturi la meniul ``notificari``
- Update 3:
    - Nucleu:
        - Adaugarea utilitarului ``lusion`` scris in PHP
        - Sistem de verificare a noutatilor si extragerea
        - Implementarea unui task center
    - User:
        - Poate sa vada si sa creeze sarcini (cronjob)
        - Acces utilizator la utilitarul ``lusion``
        - Noutati cu privire la BSD, Metin2, PHP, SQL (daca vrea)
    - Admin:
        - Acces admin la utilitarul ``lusion``
        - Noutati LusionCP + ce are utilizatorul

## LusionCP v2
========
> **NOTA:** LusionCP versiunea 2 este foarte instabil. Un singur lucru de spus: v2 este v1 in OOP + functii noi. Deoarece lcpv2 va fi next-gen, va folosi librarii mai noi si mai stabile.

- Target:
    - FreeBSD 8, 9, 10
    - Linux (Ubuntu 14.04, 14.10, 15.04)
    - Mai multe jocuri!
    - Mai multe limbi!
    - Mai multe interfete grafice!
    - Web host manager
    - Web host control panel
    - Mailing control panel (???)
    - File hosting panel (???)
    - Windows Server (???)
