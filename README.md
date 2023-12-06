# Guida Sviluppo di un sito E-Commerce con PHP

Nel contesto dell'odierno panorama digitale in costante evoluzione, presento questa guida dedicata all'implementazione di un sito E-commerce attraverso l'utilizzo del linguaggio di programmazione PHP. Questo tutorial fornirà una guida dettagliata per la creazione di un sito E-commerce completamente funzionante, comprensivo di moduli per la gestione del carrello, il sistema di pagamento, l'amministrazione del catalogo dei prodotti e altre funzionalità essenziali.

Nel corso di questa guida, utilizzeremo PHP in combinazione con HTML, CSS, Bootstrap, JavaScript e SQL per creare un sito E-commerce completo e dinamico.

Per semplificare il processo di sviluppo e gestione del database, sarà utilizzato XAMPP, un ambiente di sviluppo locale. 

# Indice

- [Introduzione a XAMPP](Guide/Xampp.md)
- [Impostazione del sito](Guide/Lezione1/impostazione.md)
   - [Index](Guide/Lezione1/impostazione.md#indexphp)    
   - [Header](Guide/Lezione1/impostazione.md#headerphp)
   - [Navbar](Guide/Lezione1/impostazione.md#navbarphp)
   - [Footer](Guide/Lezione1/impostazione.md#footerphp)
- [MVC E Login](Guide/Lezione2/MVC.md)
   - [Struttura delle cartelle del progetto](Guide/Lezione2/MVC.md#struttura-del-progettod)
   - [MODEL userModel.php](Guide/Lezione2/MVC.md#model-usermodelphp)
   - [CONTROL userControl.php](Guide/Lezione2/MVC.md#contrl-usercontrolphp)
   - [VIEW login.php](Guide/Lezione2/MVC.md#viewloginphp)
   - [VIEW login.js](Guide/Lezione2/MVC.md#viewloginjs)
   - [Spiegazione Chiamate Asincrone](Guide/Lezione2/MVC.md#approfondimento-su-chiamate-asincrone-e-concetto-di-asincronia)
- [Controllo Login](Guide/Lezione3/ControlloLogin.md)
   - [Aggiunte ad User Model](Guide/Lezione3/ControlloLogin.md#usermodelphp)
   - [Aggiunte ad User Control](Guide/Lezione3/ControlloLogin.md#usercontrolphp)
   - [Modifiche alla Navbar](Guide/Lezione3/ControlloLogin.md#navbarphp)
   - [Gestione Navbar con JS](Guide/Lezione3/ControlloLogin.md#implementazione-della-navbar-con-javascript)
   - [Logout nell'User Control](Guide/Lezione3/ControlloLogin.md#aggiunta-logout-nel-file-usercontrolphp)
- [Database](Guide/Lezione4/Database.md)
   - [Modello Logico Utenti](Guide/Lezione4/Database.md#modello-logico-utenti)
   - [Attivare e Gestire il DB](Guide/Lezione4/Database.md#attivare-e-gestire-il-db)
   - [Creare un database](Guide/Lezione4/Database.md#creare-un-database)
   - [Dove scrivere le query](Guide/Lezione4/Database.md#dove-scrivere-le-query)
   - [Modello Fisico Utenti (Create Table)](Guide/Lezione4/Database.md#modello-fisico-utenti-create-table)
   - [Come consegnare il database](Guide/Lezione4/Database.md#come-consegnare-il-database)
   - [Come riprendere il database](Guide/Lezione4/Database.md#come-riprendere-il-database)
- [Registrazione di un utente](Guide/Lezione5/registrazione.md)
  - [Inserimento dei tipi di utente](Guide/Lezione5/registrazione.md#inserimento-dei-tipi-di-utente)
  - [Introduzione alle modifiche al progetto](Guide/Lezione5/registrazione.md#introduzione-alle-modifiche-al-progetto)
  - [Modifiche a userModel.php](Guide/Lezione5/registrazione.md#modifiche-a-usermodelphp)
  - [Modifiche a userControl.php](Guide/Lezione5/registrazione.md#modifiche-a-usercontrolphp)
  - [Estrazione dei tipi di utente in userModel.php](Guide/Lezione5/registrazione.md#estrazione-dei-tipi-di-utente-in-usermodelphp)
  - [Estrazione dei tipi di utente - Modifiche a userControl.php](Guide/Lezione5/registrazione.md#estrazione-dei-tipi-di-utente---modifiche-a-usercontrolphp)
  - [VIEW registrazione utente - register.php](Guide/Lezione5/registrazione.md#view-registrazione-utente---registerphp)
  - [register.js - caricamento dinamico dei tipi di utenti](Guide/Lezione5/registrazione.md#registerjs---caricamento-dinamico-dei-tipi-di-utenti)
  - [register.js - registrazione di un utente](Guide/Lezione5/registrazione.md#registerjs---registrazione-di-un-utente)
  - [Modifiche a Login.js](Guide/Lezione5/registrazione.md#modifiche-a-loginjs)
- [Login e Database](Guide/Lezione6/LoginEDatabase.md)
  - [Modifiche a userModel.php](Guide/Lezione6/LoginEDatabase.md#modifiche-a-usermodelphp)
  - [Modifiche a Login.js](Guide/Lezione6/LoginEDatabase.md#modifiche-a-loginjs)
- [Aggiunta dei prodotti](Guide/Lezione7/AggiuntaProdotti.md)
   - [Progettazione tabella prodotti](Guide/Lezione7/AggiuntaProdotti.md#progettazione-tabella-prodotti)
   - [productModel.php](Guide/Lezione7/AggiuntaProdotti.md#productmodelphp)
   - [productControl.php](Guide/Lezione7/AggiuntaProdotti.md#productcontrolphp)
   - [View insertProduct.php](Guide/Lezione7/AggiuntaProdotti.md#view-insertproductphp)
   - [View insertProduct.js](Guide/Lezione7/AggiuntaProdotti.md#view-insertproductjs)
   - [Modifiche a navbar.js](Guide/Lezione7/AggiuntaProdotti.md#modifiche-a-navbarjs)
 
- [Visualizzazione Prodotti](Guide/Lezione8/VisualizzazioneProdotti.md)
   - [Aggiunte a ProductModel.php](Guide/Lezione8/VisualizzazioneProdotti.md#aggiunte-a-productmodelphp)
   - [Aggiunte a ProductControl.php](Guide/Lezione8/VisualizzazioneProdotti.md#aggiunte-a-productcontrolphp)
   - [Modifiche ad index.php](Guide/Lezione8/VisualizzazioneProdotti.md#modifiche-ad-indexphp)
   - [Aggiunta di products.js](Guide/Lezione8/VisualizzazioneProdotti.md#aggiunta-di-productsjs)




