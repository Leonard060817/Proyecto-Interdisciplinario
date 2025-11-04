package pruebaCodigo;
import java.util.ArrayList;
import java.util.List;
public class Medico extends Usuario {
	
	private String especialidad;
	private List<Turno> turnos;
	public Medico(String nombre, String usuario, String contrasena, String especialidad) {
		super(nombre, usuario, contrasena);
		this.especialidad = especialidad;
		this.turnos = new ArrayList<>();		
	}
	
	public void atenderPaciente(Paciente p) {
		 System.out.println("\nAtendiendo al paciente: " + p.getNombre());
	}
	public void registrarDiagnostico(Paciente p, String descripcion) {
	 Diagnostico d = new Diagnostico(descripcion, this);
	 p.getHistoriaClinica().agregarDiagnostico(d);
	
	 System.out.println("Diagnóstico registrado para " + p.getNombre() + ": " + descripcion);
	}
	public void agregarTurno(Turno turno) {
		 turnos.add(turno);
	}
	public List<Turno> getTurnos() {
		 return turnos;
	}
	public String getEspecialidad() {
		 return especialidad;
	}
}