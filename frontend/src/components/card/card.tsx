import styles from "./card.module.css";

function Card() {
  return (
    <>
      <div className={styles.card}>
        <img className={styles.img} src="../../assets/react.svg" />
        <p>Абоба</p>
      </div>
    </>
  );
}

export default Card;
