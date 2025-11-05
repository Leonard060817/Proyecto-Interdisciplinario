package pruebaCodigo;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

	public class Paciente extends Usuario {
		private String email;
		private String telefono;
		private HistoriaClinica historiaClinica;
		private List<Turno> turnos;
		
	public Paciente(String nombre, String usuario, String contrasena, String email, String telefono) {
		super(nombre, usuario, contrasena);
		this.email = email;
		this.telefono = telefono;
		this.historiaClinica = new HistoriaClinica();
		this.turnos = new ArrayList<>();
		
	}
	
	public Turno solicitarTurno(Medico medico, Date fecha) {
		Turno turno = new Turno(fecha, "10:00", "Pendiente", this, medico);
		turnos.add(turno);
		System.out.println("Turno solicitado con el Dr. " + medico.getNombre() + " para el " + fecha);
		return turno;
	}
	public HistoriaClinica getHistoriaClinica() {
		return this.historiaClinica;
}
	public void verHistoriaClinica() {
		System.out.println("\n--- Historia Clínica de " + getNombre() + " ---");
		historiaClinica.mostrar();
}
	public List<Turno> getTurnos() {
		return turnos;
	}
}