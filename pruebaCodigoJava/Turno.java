package pruebaCodigo;
import java.util.Date;
	public class Turno {
	
	private Date fecha;
	private String hora;
	private String estado;
	private Paciente paciente;
	private Medico medico;
	
	public Turno(Date fecha, String hora, String estado, Paciente paciente, Medico medico) {
		 this.fecha = fecha;
		 this.hora = hora;
		 this.estado = estado;
		 this.paciente = paciente;
		 this.medico = medico;
		 }
	
	 public void confirmar() {
		 this.estado = "Confirmado";
		 System.out.println("Turno confirmado para el " + fecha);
		 }
		 public void cancelar() {
		 this.estado = "Cancelado";
		 System.out.println("Turno cancelado para el " + fecha);
		 }
		 public Date getFecha() { return fecha; }
		 public String getHora() { return hora; }
		 public String getEstado() { return estado; }
		 public Paciente getPaciente() { return paciente; }
		 public Medico getMedico() { return medico; }
		 public void setEstado(String estado) { this.estado = estado; }
		 @Override
		 public String toString() {
		 return "\nTurno del " + fecha + " con el Dr. " + medico.getNombre() +
		 " para el paciente " + paciente.getNombre() +
		 " | Estado: " + estado;
		 }
}