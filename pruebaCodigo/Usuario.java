package pruebaCodigo;
import java.util.Scanner;
public class Usuario {
	
	private String nombre;
	private String usuario;
	private String contrasena;
	
	public Usuario(String nombre, String usuario, String contrasena){
		this.nombre = nombre;
		this.usuario = usuario;
		this.contrasena = contrasena;
	}
	
	public boolean validarAcceso(String usuarioIngresado, String contrasenaIngresada) {
		return this.usuario.equals(usuarioIngresado) && this.contrasena.equals(contrasenaIngresada);
	}
	
	public void iniciarSesion() {
		
		Scanner sc = new Scanner(System.in);
			
		System.out.println("\n--- Inicio de Sesión ---");
			
		System.out.print("Usuario: ");
			
		String usuarioIntento = sc.nextLine();
			
		System.out.print("Contraseña: ");
			
		String contrasenaIntento = sc.nextLine();
			
		if (validarAcceso(usuarioIntento, contrasenaIntento)) {
				
			System.out.println("\nAcceso Concedido.");
				
			System.out.println("Bienvenido, " + this.nombre);
				
		} else {
				
			System.out.println("\nAcceso denegado.");
			System.out.println("Usuario o contraseña incorrectos.");
				
		}
	
	 sc.close();
	}
	
	public String getNombre() {
		return nombre;
	}
	
	public String getUsuario() {
		return usuario;
	}
}