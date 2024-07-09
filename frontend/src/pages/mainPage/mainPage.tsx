import styles from "./mainPage.module.css";
import Card from "../../components/card/card";

function MainPage() {
  return (
    <>
      <header className={styles.header}>
        <nav className={styles.nav}>
          <div>Logo</div>
          <div className={styles.category}>
            <p className={styles.textCategory}>Ремень</p>
            <p className={styles.textCategory}>Сумка</p>
            <p className={styles.textCategory}>Обувь</p>
          </div>
          <div className={styles.auth}>
            <p className={styles.textAuth}>Войти</p>
            <p className={styles.textAuth}>Зарегистрироваться</p>
          </div>
        </nav>
      </header>
      <main className={styles.main}>
        <h1 className={styles.titleText}>Главная страница</h1>
        <div className={styles.card_style}>
          <Card />
          <Card />
          <Card />
          <Card />
          <Card />
          <Card />
          <Card />
          <Card />
          <Card />
          <Card />
          <Card />
        </div>
      </main>
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
