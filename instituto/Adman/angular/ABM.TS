/*import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UsuariosService {
  url = 'http://127.0.0.1:80/webServicesPHP-Angular/';


  constructor(private http: HttpClient) { }
  mostrarTodos(){

    return this.http.get(`${this.url}mostrarTodos.php`);

  }
  agregar(usuario){
    return this.http.post(`${this.url}ajax_usuarios.php`, JSON.stringify(usuario));
  }
  eliminar(id_usuario:number){
    return this.http.get(`${this.url}edit_usuarios.php?id_usuario=${id_usuario}`);
  }
  seleccionar(id_usuario:number){
    return this.http.get(`${this.url}seleccionar.php?id_usuario=${id_usuario}`);
  }
  update(usuario){
    return this.http.post(`${this.url}update.php`, JSON.stringify(usuario));
  }

}