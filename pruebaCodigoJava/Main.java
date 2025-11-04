package pruebaCodigo;
import java.util.Date;

public class Main {

	public static void main(String[] args) {
		
		Medico medico1 = new Medico("Juan Pérez", "jperez", "pass1", "Cardiologia");
		Medico medico2 = new Medico("Ana Gómez", "agomez", "pass2", "Pediatria");
		Paciente paciente1 = new Paciente("Carlos López", "clopez", "pass3", "carlos@mail.com", "555-1234");
		Paciente paciente2 = new Paciente("María Díaz", "mdiaz", "pass4", "maria@mail.com", "555-5678");
		
        Diagnostico diag1 = new Diagnostico("Gripe leve, reposo y medicación.", medico1);
        Diagnostico diag2 = new Diagnostico("Dolor de espalda crónico, sugerida fisioterapia.", medico2);
        Diagnostico diag3 = new Diagnostico("Chequeo general: todo normal.", medico1);
        
        paciente1.getHistoriaClinica().agregarDiagnostico(diag1);
        paciente1.getHistoriaClinica().agregarDiagnostico(diag3);
        paciente2.getHistoriaClinica().agregarDiagnostico(diag2);
        
        System.out.println("=== Historia Clínica de Carlos López ===");
        paciente1.getHistoriaClinica().mostrar();
        
        System.out.println("=== Historia Clínica de María Díaz ===");
        paciente2.getHistoriaClinica().mostrar();
        Turno turno1 = new Turno(new Date(), "10:30", "Pendiente", paciente1, medico1);
        Turno turno2 = new Turno(new Date(), "15:00", "Pendiente", paciente2, medico2);

        System.out.println("\n=== Turnos Iniciales ===");
        System.out.println(turno1);
        System.out.println(turno2);

        turno1.confirmar();
        turno2.cancelar();

        System.out.println("\n=== Turnos Actualizados ===");
        System.out.println(turno1);
        System.out.println(turno2);

        turno2.setEstado("Reprogramado");
        System.out.println("\n=== Turno 2 Reprogramado ===");
        System.out.println(turno2);


	}

}
