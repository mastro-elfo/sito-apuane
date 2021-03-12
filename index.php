<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Informazioni e curiosità sulle Alpi Apuane."
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/home.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
    <link rel="icon" href="favicon.png" type="image/png"/>
    <title>Vette Apuane</title>
  </head>
  <body>
    <header>
      <h1>Alpi Apuane</h1>
    </header>

    <?php require("php/nav.php"); ?>

    <aside class="center">
      <video autoplay controls muted title="Un video sulla montagna">
        <source src="./video/montagna.mp4" type="video/mp4" />
      </video>
    </aside>

    <main>
      <article>
        <header>
          <h2>Monte Pisanino</h2>
        </header>

        <section>
          <p>
            <img
              src="imgs/pisanino.jpeg"
              alt="La vetta del monte Pisanino"
              title="Monte Pisanino"
            />
            Il Pisanino, insieme al Monte Prado situato in <strong>Garfagnana</strong> a nord-est
            del Pisanino, è tra le montagne più alte appartenenti interamente
            alla Toscana. La vetta si trova in provincia di Lucca nel comune di
            Minucciano.
          </p>
        </section>

        <section>
          <h3>Curiosità</h3>
          <p>Il Pisanino è la vetta più alta delle Alpi Apuane.</p>
        </section>

        <footer>
          <p>(<time datetime="2021-02-26">26 febbraio 2021</time>)</p>
        </footer>
      </article>

      <article>
        <header>
          <h2>Monte Tambura</h2>
        </header>
        <section>
          <p>
            <img
              src="imgs/tambura.jpeg"
              alt="La vetta del monte Tambura"
              title="Monte Tambura"
            />
            Il Monte Tambura è una montagna di 1895 metri, la seconda per
            altezza della catena delle Alpi Apuane, al confine tra la Provincia
            di Lucca e la Provincia di Massa e Carrara, compreso nel territorio
            del <strong>Parco naturale regionale delle Alpi Apuane</strong> con la vetta che si
            trova nel comune di Vagli di Sotto.
          </p>
        </section>
        <section>
          <h3>Curiosità</h3>
          <p>
            La <strong>Via Vandelli</strong> attraversa il passo della Tambura e
            collega le città di Massa e Modena.
          </p>
        </section>
        <footer>
          <p>(<time datetime="2021-02-26">26 febbraio 2021</time>)</p>
        </footer>
      </article>

      <article>
        <header>
          <h2>Pania della Croce</h2>
        </header>
        <section>
          <p>
            <img
              src="imgs/pania_della_croce.jpg"
              alt="La vetta della Pania della Croce"
              title="Pania della Croce"
            />
            La Pania della Croce è la quarta cima più alta delle Alpi Apuane e
            la più alta del Gruppo delle Panie, gruppo di notevole interesse
            paesaggistico, alpinistico e geologico, che sorge al centro della
            catena Apuana a pochi chilometri dalla costa tirrenica.
          </p>
        </section>
        <footer>
          <p>(<time datetime="2021-02-26">26 febbraio 2021</time>)</p>
        </footer>
      </article>

      <article>
        <header>
          <h2>Monte Forato</h2>
        </header>
        <section>
          <p>
            <img
              src="imgs/forato.jpeg"
              alt="La vetta del monte Forato"
              title="Monte Forato"
            />
            Il monte Forato o Pania Forata è una montagna della catena toscana
            delle Alpi Apuane, nella provincia di <strong>Lucca</strong>.
          </p>
        </section>
        <section>
          <h3>Curiosità</h3>
          <p>
            La vetta del Monte Forato è caratterizzata da un arco di roccia
            naturale.
          </p>
        </section>
        <footer>
          <p>(<time datetime="2021-02-26">26 febbraio 2021</time>)</p>
        </footer>
      </article>
    </main>

    <footer>
      <p>
        Fonte: Wikipedia, visittuscany, finoincima.altervista.org,
        gettyimages.it
      </p>
    </footer>
  </body>
</html>
