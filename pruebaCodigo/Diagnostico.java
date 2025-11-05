package pruebaCodigo;
import java.util.Date;
	public class Diagnostico {
	 private Date fecha;
	 private String texto;
	 private Medico medico;
	 public Diagnostico(String texto, Medico medico) {
	 this.fecha = new Date();
	 this.texto = texto;
	 this.medico = medico;
	 }
	 @Override
	 public String toString() {
	 return "Fecha: " + fecha + "\nMédico: " + medico.getNombre() + "\nDiagnóstico: " + texto + "\n";
	 }
}