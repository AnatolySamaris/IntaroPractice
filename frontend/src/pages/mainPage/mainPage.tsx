import styles from "./mainPage.module.css";

function MainPage() {
  return (
    <>
      <header className={styles.header}>
        <div className="header-left">
          <h1>Современная одежда</h1>
        </div>
        <div className={styles.headerRight}>
          <h1 className={styles.phone}>8-800-555-35-35</h1>
          <div className={styles.searchPanel}></div>
        </div>
      </header>
      <main className={styles.main}></main>
      <footer className={styles.footer}>
        <div className="footer-logo">
          <p className={styles.footerText}>
            @ Интернет магазин одежды, 2024 - IntaroDPO
          </p>
        </div>
      </footer>
    </>
  );
}

export default MainPage;
