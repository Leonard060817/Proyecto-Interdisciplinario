package pruebaCodigo;
import java.util.ArrayList;
import java.util.List;
	public class HistoriaClinica {
	
	private List<Diagnostico> diagnosticos;
	
	public HistoriaClinica() {
		this.diagnosticos = new ArrayList<>();
}
	
	public void agregarDiagnostico(Diagnostico d) {
		diagnosticos.add(d);
}
	public void mostrar() {
		if (diagnosticos.isEmpty()) {
			System.out.println("No hay diagnósticos registrados.");
		} else {
			for (Diagnostico d : diagnosticos) {
				System.out.println(d);
}
}
}
}