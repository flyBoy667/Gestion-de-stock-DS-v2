<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
      <li class="nav-item">
          <a href="./index.php" <?php if($link == "/stock_final/index.php") echo $active; else echo("class=nav-link");?>>
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Tableau de bord</p>
          </a>
      </li>         
      <li <?php if($link == "/stock_final/user.php" OR $link == "/stock_final/reglages.php") echo $menu; else echo("class=nav-item has-treeview");  ?>>
        <a href="#" <?php if($link == "/stock_final/user.php" OR $link == "/stock_final/reglages.php") echo $active; else echo("class=nav-link");?>>
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Paramètres
              <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="./user.php"<?php if($link == "/stock_final/user.php") echo $active; else echo("class=nav-link");?>>
              <i class="far fa-circle nav-icon"></i>
                <p>Gestion utilisateur</p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="./reglages.php"<?php if($link == "/stock_final/reglages.php") echo $active; else echo("class=nav-link");?>>
              <i class="far fa-circle nav-icon"></i>
                <p>Réglages généreaux</p>
            </a>
          </li>           
        </ul>
      </li>
      <li class="nav-item">
          <a href="./categorie.php" <?php if($link == "/stock_final/categorie.php") echo $active; else echo("class=nav-link");?>>
            <i class="nav-icon fas fa-tag"></i>
            <p>Catégorie</p>
          </a>
      </li>
      <!--<li <?php if($link == "/stock_final/article.php" OR $link =="/stock_final/categorie.php") echo $menu; else echo("class=nav-item has-treeview"); ?>>
        <a href="#" <?php if($link == "/stock_final/article.php" OR $link == "/stock_final/categorie.php") echo $active; else echo("class=nav-link");?>>
            <i class="nav-icon fas fa-cubes"></i>
            <p>
              Produit
              <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="./article.php" <?php if($link == "/stock_final/article.php") echo $active; else echo("class=nav-link");?>>
              <i class="far fa-circle nav-icon"></i>
                <p>Article</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./categorie.php" <?php if($link == "/stock_final/categorie.php") echo $active; else echo("class=nav-link");?>>
              <i class="far fa-circle nav-icon"></i>
              <p>Catégorie</p>
            </a>
          </li>
        </ul>
      </li>-->
      <li class="nav-item">
        <a href="./produit.php" <?php if($link == "/stock_final/produit.php") echo $active; else echo("class=nav-link");?>>
          <i class="nav-icon fas fa-cubes"></i>
          <p>
            Produit
          </p>
        </a>
      </li>
      <li <?php if($link == "/stock_final/client.php" OR $link =="/stock_final/fournisseur.php") echo $menu; else echo("class=nav-item has-treeview"); ?>>
        <a href="#" <?php if($link == "/stock_final/client.php" OR $link == "/stock_final/fournisseur.php") echo $active; else echo("class=nav-link");?>>
            <i class="nav-icon fas fa-users"></i>
            <p>
              Clients & Fournisseurs
              <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="./client.php" <?php if($link == "/stock_final/client.php") echo $active; else echo("class=nav-link");?>>
              <i class="far fa-circle nav-icon"></i>
                <p>Clients</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./fournisseur.php" <?php if($link == "/stock_final/fournisseur.php") echo $active; else echo("class=nav-link");?>>
              <i class="far fa-circle nav-icon"></i>
              <p>Fournisseurs</p>
            </a>
          </li>
        </ul>
      </li>
      <li <?php if($link == "/stock_final/liste_achat.php" OR $link =="/stock_final/achat_fournisseur.php") echo $menu; else echo("class=nav-item has-treeview"); ?>>
        <a href="#" <?php if($link == "/stock_final/liste_achat.php" OR $link == "/stock_final/achat_fournisseur.php") echo $active; else echo("class=nav-link");?>>
            <i class="nav-icon fas fa-ship"></i>
            <p>
              Achat
              <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="./liste_achat.php" <?php if($link == "/stock_final/liste_achat.php") echo $active; else echo("class=nav-link");?>>
              <i class="far fa-circle nav-icon"></i>
                <p>Liste des achat</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./achat_fournisseur.php" <?php if($link == "/stock_final/achat_fournisseur.php") echo $active; else echo("class=nav-link");?>>
              <i class="far fa-circle nav-icon"></i>
              <p>Nouvel Achat</p>
            </a>
          </li>
        </ul>
      </li>
      <li <?php if($link == "/stock_final/liste_vente.php" OR $link =="/stock_final/vente.php") echo $menu; else echo("class=nav-item has-treeview"); ?>>
        <a href="#" <?php if($link == "/stock_final/liste_vente.php" OR $link == "/stock_final/vente.php") echo $active; else echo("class=nav-link");?>>
            <i class="nav-icon fas fa-cart-plus"></i>
            <p>
              Vente
              <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="./liste_vente.php" <?php if($link == "/stock_final/liste_vente.php") echo $active; else echo("class=nav-link");?>>
              <i class="far fa-circle nav-icon"></i>
                <p>Liste des ventes</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./vente.php" <?php if($link == "/stock_final/vente.php") echo $active; else echo("class=nav-link");?>>
              <i class="far fa-circle nav-icon"></i>
              <p>Nouvelle vente</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="./depense.php" <?php if($link == "/stock_final/depense.php") echo $active; else echo("class=nav-link");?>>
          <i class="nav-icon fas fa-dollar-sign"></i>
          <p>
            Depense
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="./rapport.php" <?php if($link == "/stock_final/rapport.php") echo $active; else echo("class=nav-link");?>>
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            Rapport
          </p>
        </a>
      </li>
    </ul>
</nav>