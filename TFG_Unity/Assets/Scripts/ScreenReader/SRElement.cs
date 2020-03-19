﻿using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class SRElement : MonoBehaviour
{
    public AudioClip audioLabel;
    public string textLabel;
    public Actable actBehaviour;
    public SRList parentList;

    // Start is called before the first frame update
    void Start()
    {
    }

    // Update is called once per frame
    void Update()
    {
        
    }

    public void ReadLabel()
    {
        if (audioLabel != null)
        {
            TTS.instance.PlayClip(audioLabel);
        }

        else {
            TTS.instance.PlayTTS(textLabel);
            Debug.Log("tts label: " + textLabel);
        }
    }

    public void ElementAct()
    {
        if (actBehaviour != null)
        {
            actBehaviour.Act();
        }
        else Debug.Log(textLabel + " is useless");
    }
}
