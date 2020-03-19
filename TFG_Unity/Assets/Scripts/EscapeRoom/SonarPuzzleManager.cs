﻿using System.Collections;
using System.Collections.Generic;
using UnityEngine;

[System.Serializable]
public struct SonarRadios
{
    public float cerca,
                medio,
                lejos;
    public void setCerca(float nCerca) { cerca = nCerca; }
    public void setMedio(float nMedio) { medio = nMedio; }
    public void setLejos(float nLejos) { lejos = nLejos; }
}

public enum SonarZones
{
    fuera,
    lejos,
    medio,
    cerca
}

public class SonarPuzzleManager : MonoBehaviour
{
    [Header("El tiempo que pasa entre vibraciones en cada zona")]
    public long vibrationRestCerca = 50;
    public long vibrationRestMedio = 333;
    public long vibrationRestLejos = 666;

    [Space(10)]

    [Tooltip("Los centros de los distintos focos de vibración")]
    [SerializeField]
    public List<Transform> centros;

    [Tooltip("Los radios de vibración de los distintos focos de vibración")]
    [SerializeField]
    public List<SonarRadios> radios;

    private bool click = false;
    private SonarZones lastZone = SonarZones.fuera;

    private void OnValidate()
    {
        //nos aseguramos que la lista de radios tiene el mismo tamaño que la de centros
        if(radios.Count != centros.Count)
        {
            //caso en el que la lista de radios es más pequeña que la de centros
            if(radios.Count < centros.Count)
            {
                //añadimos elementos a la lista de radios para que se nivele la diferencia
                for(int i =0; i< centros.Count - radios.Count; i++)
                    radios.Add(new SonarRadios());
            }
            //caso en el que la lista de radios es más grande que la de centros
            else
            {
                //quitamos elementos por atrás para nivelar la diferencia
                for(int i =0; i< radios.Count - centros.Count; i++)
                    radios.RemoveAt(radios.Count - 1);
            }
        }
        //ahora nos aseguramos que todos los radios tienen valores válidos (mayores o iguales a 0)
        for(int i = 0; i< radios.Count; i++)
        {
            if (radios[i].cerca < 0)
                radios[i].setCerca(0);
            if (radios[i].medio < 0)
                radios[i].setMedio(0);
            if (radios[i].lejos < 0)
                radios[i].setLejos(0);
        }
    }

    //para ver los radios desde el editor
    private void OnDrawGizmos()
    {
        for(int i = 0; i< centros.Count; i++)
        {
            Gizmos.DrawWireSphere(centros[i].position, radios[i].cerca);
            Gizmos.DrawWireSphere(centros[i].position, radios[i].cerca + radios[i].medio);
            Gizmos.DrawWireSphere(centros[i].position, radios[i].cerca + radios[i].medio + radios[i].lejos);
        }

        if(click)
            Gizmos.DrawWireSphere(Camera.main.ScreenToWorldPoint(Input.mousePosition), 0.2f);
    }

    void Update()
    {
        click = Input.GetMouseButton(0);
        if (click)
            ProcessClick();
        else Vibration.Cancel();
    }

    void ProcessClick()
    {
        Vector2 auxPos = Camera.main.ScreenToWorldPoint(Input.mousePosition);

        //infinito por defecto para asegurar que se ajusta el valor en la primera vuelta del bucle
        float minDist = Mathf.Infinity;
        float actDist = 0;
        int index = -1;
        //recorremos la lista
        for (int i = 0; i < centros.Count; i++)
        {
            //calculamos la distancia al centro correspondiente
            actDist = Vector2.Distance(auxPos, centros[i].position);
            //y si la distancia es menor 
            if (actDist < minDist)
            {
                //ajustamos variables
                minDist = actDist;
                index = i;
            }
        }
        CalculateVibration(index, minDist);
    }
    //calcula la vibración correspondiente dada la distancia dist al centro con indice cIndex dentro de la lista de centros
    void CalculateVibration(int cIndex, float dist)
    {
        if(dist <= radios[cIndex].cerca)
        {
            if(lastZone != SonarZones.cerca)
            {
                print("cerca");
                lastZone = SonarZones.cerca;
                Vibration.Cancel();
                Vibration.SonarVibration(0.5f, 333, vibrationRestCerca, true);
            }
        }
        else if(dist <= (radios[cIndex].medio + radios[cIndex].cerca) )
        {
            if(lastZone != SonarZones.medio)
            {
                print("medio");
                lastZone = SonarZones.medio;
                Vibration.Cancel();
                Vibration.SonarVibration(0.5f, 333, vibrationRestMedio, true);
            }
        }
        else if(dist <= (radios[cIndex].lejos + radios[cIndex].medio + radios[cIndex].cerca) )
        {
            if(lastZone != SonarZones.lejos)
            {
                print("lejos");
                lastZone = SonarZones.lejos;
                Vibration.Cancel();
                Vibration.SonarVibration(0.5f, 333, vibrationRestLejos, true);
            }
        }
        else
        {
            if(lastZone != SonarZones.fuera)
            {
                lastZone = SonarZones.fuera;
                Vibration.Cancel();
            }
        }
    }
}