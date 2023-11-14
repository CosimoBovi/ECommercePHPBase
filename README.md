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
   - [Controllo Password](Guide/Lezione4/Database.md#controllo-password)
   - [Inserimento di un utente](Guide/Lezione4/Database.md#inserimento-di-un-utente)
   - [Come consegnare il database](Guide/Lezione4/Database.md#come-consegnare-il-database)
   - [Come riprendere il database](Guide/Lezione4/Database.md#come-riprendere-il-database)
